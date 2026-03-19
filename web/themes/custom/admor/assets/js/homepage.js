(function (Drupal, once) {
  Drupal.behaviors.admorHomepage = {
    attach(context) {
      if (typeof window.Swiper !== 'function') {
        return;
      }

      once('admor-product-swiper', '.admor-product-logo-swiper', context).forEach((element) => {
        // Keep the hero product carousel lightweight and reliable.
        new window.Swiper(element, {
          slidesPerView: 1.2,
          spaceBetween: 16,
          loop: false,
          autoplay: {
            delay: 3800,
            disableOnInteraction: false
          },
          pagination: {
            el: element.querySelector('.swiper-pagination'),
            clickable: true
          },
          navigation: {
            nextEl: element.querySelector('.swiper-button-next'),
            prevEl: element.querySelector('.swiper-button-prev')
          },
          breakpoints: {
            576: {
              slidesPerView: 2
            },
            992: {
              slidesPerView: 2.4
            },
            1200: {
              slidesPerView: 3
            }
          }
        });
      });

      once('admor-testimonial-swiper', '.admor-testimonial-swiper', context).forEach((element) => {
        new window.Swiper(element, {
          slidesPerView: 1,
          spaceBetween: 24,
          loop: false,
          pagination: {
            el: element.querySelector('.swiper-pagination'),
            clickable: true
          },
          breakpoints: {
            992: {
              slidesPerView: 2
            }
          }
        });
      });
    }
  };
})(Drupal, once);
