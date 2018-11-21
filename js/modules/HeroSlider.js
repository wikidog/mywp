import $ from 'jquery';
import slick from 'slick-carousel';

class HeroSlider {
  constructor() {
    this.els = $('.hero-slider');
    this.initSlider();
  }

  initSlider() {
    this.els.slick({
      autoplay: true,
      arrows: false,
      dots: true,
    });
  }
}

export default HeroSlider;
