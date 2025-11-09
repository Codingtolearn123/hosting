(function () {
  const body = document.body;
  const mobileToggle = document.querySelector('[data-toggle-nav]');
  const mobileNav = document.querySelector('[data-mobile-nav]');
  const themeToggles = document.querySelectorAll('[data-theme-toggle]');
  const pricingButtons = document.querySelectorAll('[data-billing-toggle]');
  const accordionButtons = document.querySelectorAll('[data-accordion-toggle]');

  if (mobileToggle && mobileNav) {
    mobileToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('hidden');
      mobileNav.classList.toggle('flex');
    });
  }

  themeToggles.forEach((button) => {
    button.addEventListener('click', () => {
      const currentTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', currentTheme);
      body.classList.toggle('theme-light');
    });
  });

  if (pricingButtons.length) {
    pricingButtons.forEach((btn) => {
      btn.addEventListener('click', (event) => {
        pricingButtons.forEach((b) => b.classList.remove('bg-gradient-to-r', 'from-indigo-500', 'to-pink-500', 'text-white'));
        pricingButtons.forEach((b) => b.classList.add('border', 'border-white/10', 'text-slate-200'));
        const target = event.currentTarget;
        target.classList.add('bg-gradient-to-r', 'from-indigo-500', 'to-pink-500', 'text-white');
        target.classList.remove('border', 'border-white/10', 'text-slate-200');
      });
    });
  }

  accordionButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const panel = button.parentElement.querySelector('[data-accordion-panel]');
      const icon = button.querySelector('.dashicons');
      if (!panel) return;
      panel.classList.toggle('hidden');
      if (icon) {
        icon.classList.toggle('dashicons-plus');
        icon.classList.toggle('dashicons-minus');
      }
    });
  });

  const testimonialTrack = document.querySelector('[data-testimonial-track]');
  if (testimonialTrack && testimonialTrack.children.length > 1) {
    let index = 0;
    const items = Array.from(testimonialTrack.children);
    setInterval(() => {
      index = (index + 1) % items.length;
      testimonialTrack.style.transform = `translateX(-${index * 100}%)`;
    }, 6000);
  }

  if (virtualSkyWP?.options?.floating_chat_enabled) {
    injectChatWidget();
  }

  function injectChatWidget() {
    const widget = document.createElement('div');
    widget.className = 'fixed bottom-6 right-6 z-40';
    widget.innerHTML = `
      <button class="px-5 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow-lg shadow-indigo-500/40" data-chat-toggle>
        ${'🤖 ' + (virtualSkyWP?.options?.hero_headline || 'Virtual Sky AI')}
      </button>
      <div class="hidden mt-4 w-80 rounded-3xl border border-white/10 bg-slate-950/90 backdrop-blur-xl p-4" data-chat-panel>
        <p class="text-sm text-slate-200 mb-3">${'Ask our AI anything about plans, WHMCS, or automation.'}</p>
        <textarea class="w-full h-24 rounded-2xl bg-slate-900/70 border border-white/10 text-slate-100 p-3" placeholder="Type your question..."></textarea>
        <button class="mt-3 w-full px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold" disabled>
          Coming Soon
        </button>
      </div>
    `;
    document.body.appendChild(widget);

    const toggle = widget.querySelector('[data-chat-toggle]');
    const panel = widget.querySelector('[data-chat-panel]');
    toggle.addEventListener('click', () => {
      panel.classList.toggle('hidden');
    });
  }
})();
