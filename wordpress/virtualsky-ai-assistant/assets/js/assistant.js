(function ($) {
  'use strict';

  function appendMessage($container, role, content) {
    var $message = $('<div/>', {
      'class': 'virtualsky-ai-message ' + role,
      'text': content
    });
    $container.append($message);
    $container.scrollTop($container[0].scrollHeight);
  }

  function resetConversation($root) {
    $root.find('.virtualsky-ai-messages').empty();
    $.post(VirtualSkyAI.ajaxUrl, {
      action: 'virtualsky_ai_chat',
      nonce: VirtualSkyAI.nonce,
      message: '__reset__'
    });
  }

  function handleSubmit(event) {
    event.preventDefault();
    var $form = $(this);
    var $root = $form.closest('[data-virtualsky-ai]');
    var $messages = $root.find('.virtualsky-ai-messages');
    var message = $.trim($form.find('textarea[name="message"]').val());

    if (!message) {
      return;
    }

    appendMessage($messages, 'user', message);
    $form.find('textarea').val('');

    $.post(
      VirtualSkyAI.ajaxUrl,
      {
        action: 'virtualsky_ai_chat',
        nonce: VirtualSkyAI.nonce,
        message: message
      }
    )
      .done(function (response) {
        if (response && response.success && response.data.reply) {
          appendMessage($messages, 'assistant', response.data.reply);
        } else {
          appendMessage($messages, 'assistant', 'Sorry, something went wrong.');
        }
      })
      .fail(function () {
        appendMessage($messages, 'assistant', 'Unable to reach the AI assistant.');
      });
  }

  function handleReset(event) {
    event.preventDefault();
    var $root = $(this).closest('[data-virtualsky-ai]');
    resetConversation($root);
    $root.find('.virtualsky-ai-messages').empty();
  }

  function initFloatingWidget() {
    var $floating = $('.virtualsky-ai-floating');
    if (!$floating.length) {
      return;
    }

    $floating.on('click', '.virtualsky-ai-toggle', function () {
      var $panel = $floating.find('.virtualsky-ai-floating-panel');
      var isHidden = $panel.attr('hidden');
      if (isHidden) {
        $panel.removeAttr('hidden');
      } else {
        $panel.attr('hidden', true);
      }
    });
  }

  $(function () {
    $(document).on('submit', '.virtualsky-ai-form', handleSubmit);
    $(document).on('click', '.virtualsky-ai-reset', handleReset);
    initFloatingWidget();
  });
})(jQuery);
