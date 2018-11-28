import $ from 'jquery';
import debounce from 'lodash/debounce';

class Search {
  //
  constructor() {
    //! use our script to generate the HTML element on the page
    //!   for the search function
    //! Must run this function first
    this.addSearchHtmlElement();

    this.openButton = $('.js-search-trigger');
    this.closeButton = $('.search-overlay__close');
    this.searchOverlay = $('.search-overlay');
    this.searchField = $('#search-term');
    this.resultsDiv = $('#search-overlay__results');

    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousSearchValue;

    this.events();
    this.debounced = debounce(this.queryApi, 800);
  }

  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));

    $(document).on('keydown', this.keyPressDispatcher.bind(this));

    this.searchField.on('keyup', this.typingLogic.bind(this));
  }

  typingLogic(e) {
    const currentSearchValue = this.searchField.val();

    //! fires up the logic only when the value of the search field changes
    if (currentSearchValue != this.previousSearchValue) {
      //
      //! cancel the previous debounced when the search value changes
      this.debounced.cancel();

      // search value is not empty
      if (currentSearchValue) {
        if (!this.isSpinnerVisible) {
          this.isSpinnerVisible = true;
          this.resultsDiv.html('<div class="spinner-loader"></div>');
        }
        this.debounced(e);
      } else {
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }

      this.previousSearchValue = currentSearchValue;
    }
  }

  queryApi(e) {
    $.getJSON(
      `${
        themeScriptData.site_url
      }/wp-json/my-theme/v1/search?term=${this.searchField.val()}`,
      data => {
        this.resultsDiv.html(`
          <div class="row">
            <div class="one-third">
              <h2 class="search-overlay__section-title">General Information</h2>
              ${
                data.generalInfo.length
                  ? '<ul class="link-list min-list">'
                  : '<p>No general information matches that search.</p>'
              }
                ${data.generalInfo
                  .map(
                    item =>
                      `<li><a href="${item.permalink}">${item.title}</a> ${
                        item.postType === 'post' ? `by ${item.authorName}` : ''
                      }
                      </li>`
                  )
                  .join('')}
              ${data.generalInfo.length ? '</ul>' : ''}
            </div>
            <div class="one-third">
              <h2 class="search-overlay__section-title">Programs</h2>
              ${
                data.programs.length
                  ? '<ul class="link-list min-list">'
                  : `<p>No programs match that search. <a href="${
                      themeScriptData.site_url
                    }/programs">View all programs</a></p>`
              }
                ${data.programs
                  .map(
                    item =>
                      `<li><a href="${item.permalink}">${item.title}</a></li>`
                  )
                  .join('')}
              ${data.programs.length ? '</ul>' : ''}

              <h2 class="search-overlay__section-title">Professors</h2>
              ${
                data.professors.length
                  ? '<ul class="professor-cards">'
                  : '<p>No professors match that search.</p>'
              }
                ${data.professors
                  .map(
                    item => `
<li class="professor-card__list-item">
  <a  class="professor-card" href="${item.permalink}">
    <img class="professor-card__image" src="${item.image}">
    <span class="professor-card__name">${item.title}</span>
  </a>
</li>
                    `
                  )
                  .join('')}
              ${data.professors.length ? '</ul>' : ''}
            </div>
            <div class="one-third">
              <h2 class="search-overlay__section-title">Campuses</h2>
              ${
                data.campuses.length
                  ? '<ul class="link-list min-list">'
                  : `<p>No campuses match that search. <a href="${
                      themeScriptData.site_url
                    }/campuses">View all campuses</a></p>`
              }
                ${data.campuses
                  .map(
                    item =>
                      `<li><a href="${item.permalink}">${item.title}</a></li>`
                  )
                  .join('')}
              ${data.campuses.length ? '</ul>' : ''}

              <h2 class="search-overlay__section-title">Events</h2>
              ${
                data.events.length
                  ? ''
                  : `<p>No events match that search. <a href="${
                      themeScriptData.site_url
                    }/events">View all events</a></p>`
              }
              ${data.events
                .map(
                  item => `
<div class="event-summary">
  <a class="event-summary__date t-center" href="${item.permalink}">
    <span class="event-summary__month">${item.month}</span>
    <span class="event-summary__day">${item.day}</span>
  </a>
  <div class="event-summary__content">
    <h5 class="event-summary__title headline headline--tiny"><a href="${
      item.permalink
    }">${item.title}</a></h5>
    <p>${item.description} <a href="${
                    item.permalink
                  }" class="nu gray">Read more</a></p>
  </div>
</div>
                  `
                )
                .join('')}
            </div>
          </div>
        `);

        this.isSpinnerVisible = false;
      }
    );

    //! running multiple API requests asynchronously
    /*
    $.when(
      $.getJSON(
        `${
          themeScriptData.site_url
        }/wp-json/wp/v2/posts?search=${this.searchField.val()}`
      ),
      $.getJSON(
        `${
          themeScriptData.site_url
        }/wp-json/wp/v2/pages?search=${this.searchField.val()}`
      )
    ).then(
      (posts, pages) => {
        // console.log(posts);
        // console.log(pages);
        const data = posts[0].concat(pages[0]);
        // console.log(data);
        const resultsHeader =
          '<h2 class="search-overlay__section-title">General Information</h2>';

        if (data.length) {
          this.resultsDiv.html(`
            ${resultsHeader}
            <ul class="link-list min-list">
              ${data
                .map(
                  item =>
                    `<li><a href="${item.link}">${item.title.rendered}</a> ${
                      item.type === 'post' ? `by ${item.authorName}` : ''
                    }
                    </li>`
                )
                .join('')}
            </ul>
          `);
        } else {
          this.resultsDiv.html(
            `${resultsHeader}<p>No general information matches that search.</p>`
          );
        }

        this.isSpinnerVisible = false;
      },
      //! error handling
      () => {
        this.resultsDiv.html('<p>Unexpected error; please try again.</p>');
      }
    );
    */

    // this.isSpinnerVisible = false;
  }

  keyPressDispatcher(e) {
    /**
     *! since we are using 'keydown' event and if the user presses and holds
     *! the key, the 'keydown' event will keep firing.
     *! Using a flag (isOverlayOpen) is to avoid the handler function
     *! gets called repeatedly.
     */
    if (
      e.keyCode === 83 &&
      !this.isOverlayOpen &&
      /**
       *! this is to prevent the short-cut key invoking the search overlay
       *! when user is typing in the input or textarea field
       */
      !$('input, textarea').is(':focus')
    ) {
      // this is the "s" key
      this.openOverlay();
    }

    if (e.keyCode === 27 && this.isOverlayOpen) {
      // this is the "esp" key
      this.closeOverlay();
    }
  }

  openOverlay() {
    //! clear the previous search term in the input field
    //!   but keep the previous search results
    this.searchField.val('');
    // this.resultsDiv.html('');
    // this.isSpinnerVisible = false;

    this.searchOverlay.addClass('search-overlay--active');
    $('body').addClass('body-no-scroll');
    /**
     *! why the delay is needed is because some browser only can focus when
     *!   the element is visible.
     *! There is transition period before the overlay becomes visible.
     *!   This is why we need to wait for a little bit before we fire the
     *!   focus action.
     */
    setTimeout(() => this.searchField.focus(), 301);
    //
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass('search-overlay--active');
    $('body').removeClass('body-no-scroll');
    this.isOverlayOpen = false;
  }

  addSearchHtmlElement() {
    $('body').append(`
      <div class="search-overlay">
        <div class="search-overlay__top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>
        </div>
        <div class="container">
          <div id="search-overlay__results"></div>
        </div>
      </div>
    `);
  }
}

export default Search;
