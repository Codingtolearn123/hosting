(function (window, document) {
  function init() {
    const body = document.body;
    const mobileToggle = document.querySelector('[data-toggle-nav]');
    const mobileNav = document.querySelector('[data-mobile-nav]');
    const themeToggles = document.querySelectorAll('[data-theme-toggle]');
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

    initReactComponents();
  }

  function initReactComponents() {
    if (!window.wp || !window.wp.element) {
      return;
    }

    const plansNodes = document.querySelectorAll('[data-pricing-react]');
    const { createElement: h, useState, useMemo, Fragment, RawHTML } = window.wp.element;
    const { render } = window.wp.element;
    const { __ } = (window.wp.i18n || { __: (text) => text });

    plansNodes.forEach((node) => {
      const plans = safeParse(node.dataset.plans);
      const showPromo = node.dataset.promo === '1';
      node.innerHTML = '';

      function PricingGrid() {
        const [billing, setBilling] = useState('monthly');
        const normalizedPlans = useMemo(() => (Array.isArray(plans) ? plans : []), [plans]);

        if (!normalizedPlans.length) {
          return h(
            'div',
            { className: 'p-8 rounded-3xl border border-dashed border-white/20 text-center text-slate-300' },
            __('Create hosting plans to showcase pricing here.', 'virtualskywp')
          );
        }

        const toggleClass = (value) =>
          value === billing
            ? 'px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-medium shadow'
            : 'px-4 py-2 rounded-full border border-white/10 text-slate-200';

        return h(
          Fragment,
          null,
          h(
            'div',
            { className: 'flex items-center justify-center gap-4 mb-10' },
            h(
              'button',
              {
                type: 'button',
                className: toggleClass('monthly'),
                onClick: () => setBilling('monthly'),
              },
              __('Monthly', 'virtualskywp')
            ),
            h(
              'button',
              {
                type: 'button',
                className: toggleClass('yearly'),
                onClick: () => setBilling('yearly'),
              },
              __('Yearly', 'virtualskywp')
            )
          ),
          h(
            'div',
            { className: 'grid gap-8 lg:grid-cols-4' },
            normalizedPlans.map((plan) => h(PlanCard, { key: plan.id, plan, billing, showPromo }))
          )
        );
      }

      function PlanCard({ plan, billing, showPromo }) {
        const monthly = plan.price_monthly || '';
        const yearly = plan.price_yearly || '';
        const highlighted = plan.highlighted ? ' ring-2 ring-pink-400/70' : '';
        const price = billing === 'monthly' ? monthly : yearly;
        const otherPrice = billing === 'monthly' ? yearly : monthly;
        const suffix = billing === 'monthly' ? __('mo', 'virtualskywp') : __('yr', 'virtualskywp');
        const features = Array.isArray(plan.features) ? plan.features : [];
        const hasPrice = price && typeof price === 'string';
        const otherSuffix = billing === 'monthly' ? __('yr', 'virtualskywp') : __('mo', 'virtualskywp');
        const hasOther = otherPrice && typeof otherPrice === 'string';

        const excerptContent = plan.excerpt
          ? RawHTML
            ? h(RawHTML, { children: plan.excerpt })
            : plan.excerpt
          : null;

        return h(
          'article',
          {
            className:
              'relative p-8 rounded-3xl border border-white/10 bg-slate-950/70 backdrop-blur-xl flex flex-col gap-6 shadow-xl shadow-slate-900/40' +
              highlighted,
          },
          plan.highlighted
            ? h(
                'span',
                {
                  className:
                    'absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-xs font-semibold uppercase tracking-widest text-white',
                },
                plan.badge_text || __('Best Value', 'virtualskywp')
              )
            : null,
          h(
            'div',
            { className: 'space-y-3' },
            h('h3', { className: 'text-2xl font-semibold text-white' }, plan.title || ''),
            excerptContent ? h('p', { className: 'text-sm text-slate-400' }, excerptContent) : null
          ),
          h(
            'div',
            { className: 'space-y-2' },
            showPromo && plan.promo_price
              ? h(
                  'div',
                  { className: 'text-3xl font-bold text-white' },
                  plan.promo_price,
                  h(
                    'span',
                    { className: 'text-base text-slate-400 font-medium' },
                    ' ',
                    __('first month', 'virtualskywp')
                  )
                )
              : null,
            hasPrice
              ? h(
                  'div',
                  { className: 'text-sm text-slate-400' },
                  `${price}/${suffix}`,
                  hasOther ? ` · ${__('or', 'virtualskywp')} ${otherPrice}/${otherSuffix}` : ''
                )
              : null
          ),
          h(
            'ul',
            { className: 'space-y-2 text-sm text-slate-300' },
            features.slice(0, 6).map((feature, index) =>
              h(
                'li',
                { key: `${plan.id}-feature-${index}`, className: 'flex items-start gap-2' },
                h('span', { className: 'mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500' }),
                h('span', null, feature)
              )
            ),
            plan.free_domain
              ? h(
                  'li',
                  { className: 'flex items-start gap-2 text-indigo-200' },
                  h('span', { className: 'mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500' }),
                  h('span', null, __('Free domain for the first year', 'virtualskywp'))
                )
              : null,
            plan.ai_ready
              ? h(
                  'li',
                  { className: 'flex items-start gap-2 text-pink-200' },
                  h('span', { className: 'mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500' }),
                  h('span', null, __('Optimized for AI workloads', 'virtualskywp'))
                )
              : null
          ),
          plan.whmcs_link
            ? h(
                'a',
                {
                  href: plan.whmcs_link,
                  className:
                    'mt-auto inline-flex items-center justify-center px-6 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow',
                },
                __('Buy via WHMCS', 'virtualskywp')
              )
            : null,
          plan.n8n_webhook
            ? h(
                'p',
                { className: 'text-[11px] text-slate-500 italic' },
                __('Automates VPS deployment with n8n on purchase.', 'virtualskywp')
              )
            : null
        );
      }

      render(h(PricingGrid), node);
    });

    const chatRoot = document.querySelector('[data-chat-react]');
    if (chatRoot && window.virtualSkyWP?.options?.floating_chat_enabled) {
      const { hero_headline: heroHeadline = 'Virtual Sky AI' } = window.virtualSkyWP.options;
      chatRoot.innerHTML = '';

      function ChatWidget() {
        const [open, setOpen] = useState(false);
        return h(
          'div',
          { className: 'fixed bottom-6 right-6 z-40' },
          h(
            'button',
            {
              type: 'button',
              className:
                'px-5 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow-lg shadow-indigo-500/40 flex items-center gap-2',
              onClick: () => setOpen(!open),
            },
            '🤖',
            ' ',
            heroHeadline
          ),
          open
            ? h(
                'div',
                {
                  className:
                    'mt-4 w-80 rounded-3xl border border-white/10 bg-slate-950/90 backdrop-blur-xl p-4 space-y-3',
                },
                h(
                  'p',
                  { className: 'text-sm text-slate-200' },
                  __('Ask our AI anything about plans, WHMCS, or automation.', 'virtualskywp')
                ),
                h('textarea', {
                  className:
                    'w-full h-24 rounded-2xl bg-slate-900/70 border border-white/10 text-slate-100 p-3 resize-none',
                  placeholder: __('Type your question…', 'virtualskywp'),
                  disabled: true,
                }),
                h(
                  'button',
                  {
                    type: 'button',
                    className:
                      'w-full px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold',
                    disabled: true,
                  },
                  __('Coming Soon', 'virtualskywp')
                )
              )
            : null
        );
      }

      render(h(ChatWidget), chatRoot);
    }
  }

  function safeParse(json) {
    try {
      return JSON.parse(json || '[]');
    } catch (error) {
      console.error('Failed to parse plan data', error);
      return [];
    }
  }

  document.addEventListener('DOMContentLoaded', init);
})(window, document);
