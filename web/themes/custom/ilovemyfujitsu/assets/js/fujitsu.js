(function (Drupal, once) {
  Drupal.behaviors.fujitsuDemand = {
    attach(context) {
      once('fujitsuDemand', '.js-fujitsu-proof', context).forEach((section) => {
        section.classList.add('is-ready');
      });

      const revealItems = once(
        'fujitsuReveal',
        '.fujitsu-pull, .fujitsu-contractor-flow, .fujitsu-feature-band, .fujitsu-stories, .fujitsu-home-faces, .fujitsu-resources, .ilf-testimonials, .ilf-comparison-choice, .ilf-comparison-faq, .ilf-teaser-card, .ilf-detail-card, .ilf-card-grid article',
        context,
      );

      once('fujitsuDealerClick', 'a[data-ilf-contractor-link], a[href*="contractors.fujitsugeneral.com"]', context).forEach((link) => {
        link.addEventListener('click', () => {
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push({
            event: 'fujitsu_dealer_click',
            link_url: link.href,
            link_text: link.textContent.trim(),
          });
        });
      });

      if (!('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('is-visible'));
        return;
      }

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

      revealItems.forEach((item) => {
        item.classList.add('ilf-reveal');
        observer.observe(item);
      });
    },
  };
})(Drupal, once);
