(function (Drupal, once) {
  Drupal.behaviors.admorEnhancements = {
    attach(context) {
      once('admor-external-links', 'a[target="_blank"]', context).forEach((link) => {
        if (!link.hasAttribute('rel')) {
          link.setAttribute('rel', 'noopener noreferrer');
        }
      });
    }
  };
})(Drupal, once);
