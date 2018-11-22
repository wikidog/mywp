import $ from 'jquery';
import debounce from 'lodash/debounce';

class Search {
  constructor() {
    this.openButton = $('.js-search-trigger');
    this.closeButton = $('.search-overlay__close');
    this.searchOverlay = $('.search-overlay');
    this.searchField = $('#search-term');
    this.resultsDiv = $('#search-overlay__results');
    this.events();
    this.isOverlayOpen = false;
    this.typingTimer;
  }

  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));

    $(document).on('keydown', this.keyPressDispatcher.bind(this));

    this.searchField.on('keydown', debounce(this.typingLogic.bind(this), 2000));
  }

  typingLogic() {
    this.resultsDiv.html('imagine real ');
  }

  keyPressDispatcher(e) {
    /**
     *! since we are using 'keydown' event and if the user presses and holds
     *! the key, the 'keydown' event will keep firing.
     *! Using a flag (isOverlayOpen) is to avoid the handler function
     *! gets called repeatedly.
     */
    if (e.keyCode === 83 && !this.isOverlayOpen) {
      // this is the "s" key
      this.openOverlay();
    }

    if (e.keyCode === 27 && this.isOverlayOpen) {
      // this is the "esp" key
      this.closeOverlay();
    }
  }

  openOverlay() {
    this.searchOverlay.addClass('search-overlay--active');
    $('body').addClass('body-no-scroll');
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass('search-overlay--active');
    $('body').removeClass('body-no-scroll');
    this.isOverlayOpen = false;
  }
}

export default Search;
