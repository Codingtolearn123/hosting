(function ($) {
  'use strict';

  function highlightBestPlan() {
    var cards = $('.pricing-card');
    var bestCard = null;
    var bestPrice = Infinity;

    cards.each(function () {
      var text = $(this).find('.price').text();
      var match = text.match(/([0-9]+\.?[0-9]*)/);
      if (!match) {
        return;
      }
      var price = parseFloat(match[1]);
      if (price < bestPrice) {
        bestPrice = price;
        bestCard = $(this);
      }
    });

    if (bestCard) {
      bestCard.addClass('highlight');
      bestCard.attr('aria-label', bestCard.attr('aria-label') || 'Best value');
    }
  }

  function attachWhmcsTooltips() {
    $('[data-whmcs-target]').each(function () {
      var label = $(this).attr('data-whmcs-target');
      $(this).attr('title', 'Link to WHMCS: ' + label);
    });
  }

  $(function () {
    highlightBestPlan();
    attachWhmcsTooltips();
  });
})(jQuery);
