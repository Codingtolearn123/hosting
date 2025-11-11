(function () {
  'use strict';

  function postAi(message, action) {
    var formData = new FormData();
    formData.append('virtualsky_ai_action', action || 'chat');
    if (message) {
      formData.append('message', message);
    }

    return fetch(window.location.href, {
      method: 'POST',
      credentials: 'same-origin',
      body: formData
    }).then(function (response) {
      return response.json();
    });
  }

  function appendAiMessage(container, role, text) {
    var message = document.createElement('div');
    message.className = 'vs-ai-message ' + role;
    message.textContent = text;
    container.appendChild(message);
    container.scrollTop = container.scrollHeight;
  }

  function initAiWidget() {
    var widget = document.querySelector('[data-vs-ai-widget]');
    if (!widget) {
      return;
    }

    var toggle = widget.querySelector('.vs-ai-toggle');
    var panel = widget.querySelector('.vs-ai-panel');
    var form = widget.querySelector('.vs-ai-form');
    var textarea = form.querySelector('textarea');
    var messages = widget.querySelector('.vs-ai-messages');
    var resetButton = widget.querySelector('[data-vs-ai-reset]');

    toggle.addEventListener('click', function () {
      if (panel.hasAttribute('hidden')) {
        panel.removeAttribute('hidden');
      } else {
        panel.setAttribute('hidden', 'hidden');
      }
    });

    form.addEventListener('submit', function (event) {
      event.preventDefault();
      var text = textarea.value.trim();
      if (!text) {
        return;
      }
      appendAiMessage(messages, 'user', text);
      textarea.value = '';
      postAi(text, 'chat')
        .then(function (data) {
          if (data && data.success && data.reply) {
            appendAiMessage(messages, 'assistant', data.reply);
          } else {
            appendAiMessage(messages, 'assistant', data.message || 'Sorry, something went wrong.');
          }
        })
        .catch(function () {
          appendAiMessage(messages, 'assistant', 'Unable to reach the AI assistant.');
        });
    });

    resetButton.addEventListener('click', function () {
      messages.innerHTML = '';
      postAi('', 'reset');
    });
  }

  function initThemeToggle() {
    var toggle = document.querySelector('[data-vs-toggle-theme]');
    if (!toggle) {
      return;
    }
    toggle.addEventListener('click', function () {
      document.body.classList.toggle('vs-light');
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initAiWidget();
    initThemeToggle();
  });
})();
