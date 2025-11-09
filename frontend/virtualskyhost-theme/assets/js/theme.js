(function () {
  const navToggle = document.querySelector('[data-toggle-nav]');
  const navigation = document.querySelector('.site-navigation');
  const toast = createToast();

  if (navToggle && navigation) {
    navToggle.addEventListener('click', () => {
      navigation.classList.toggle('is-open');
    });

    navigation.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        navigation.classList.remove('is-open');
      });
    });
  }

  document.querySelectorAll('[data-domain-search]').forEach((form) => {
    const input = form.querySelector('input[name="domain"]');
    const submit = form.querySelector('[data-domain-submit]');

    if (!input || !submit) {
      return;
    }

    submit.addEventListener('click', (event) => {
      event.preventDefault();
      const domain = input.value.trim();

      if (!domain) {
        showToast(toast, 'Enter a domain name to search.');
        return;
      }

      const endpoint = (window.virtualSkyHost && window.virtualSkyHost.domainSearchEndpoint) || '';

      if (!endpoint) {
        showToast(toast, 'Domain search endpoint is not configured.');
        return;
      }

      showToast(toast, `Checking ${domain}...`, { sticky: true });

      fetch(`${endpoint}?domain=${encodeURIComponent(domain)}`)
        .then((response) => response.json())
        .then((data) => {
          if (data && data.available) {
            showToast(
              toast,
              `${domain} is available! <a href="${window.virtualSkyHost.orderBaseUrl}&a=add&domain=${encodeURIComponent(domain)}" style="color:#fff; text-decoration:underline;">Register now</a>`
            );
          } else {
            showToast(toast, `${domain} is already registered. Try another extension.`);
          }
        })
        .catch(() => {
          showToast(toast, 'We could not reach the domain search service. Please try again.');
        });
    });
  });

  document.querySelectorAll('[data-pricing-grid]').forEach((grid) => {
    if (grid.children.length > 0) {
      return;
    }

    const category = grid.getAttribute('data-category') || 'shared';
    const endpoint = (window.virtualSkyHost && window.virtualSkyHost.pricingEndpoint) || '';

    if (!endpoint) {
      return;
    }

    fetch(`${endpoint}?category=${encodeURIComponent(category)}`)
      .then((response) => response.json())
      .then((plans) => {
        if (!Array.isArray(plans) || plans.length === 0) {
          grid.innerHTML = '<p>No plans available. Check back soon.</p>';
          return;
        }

        grid.innerHTML = plans
          .map((plan) => {
            const features = Array.isArray(plan.features) ? plan.features : [];
            return `
              <article class="vs-card" data-plan="${plan.id || ''}">
                <h3 style="margin:0; font-size:1.35rem;">${plan.name || 'Plan'}</h3>
                <div class="price">${plan.price || '$0.00'} <span>/mo</span></div>
                <p>${plan.description || 'Optimized for performance and scalability.'}</p>
                <ul style="list-style:none; padding:0; display:grid; gap:0.6rem;">
                  ${features.map((feature) => `<li>${feature}</li>`).join('')}
                </ul>
                <a class="vs-button" href="${window.virtualSkyHost.orderBaseUrl}&a=add&pid=${plan.product_id || ''}">
                  Buy Now
                </a>
              </article>
            `;
          })
          .join('');
      })
      .catch(() => {
        grid.innerHTML = '<p>Unable to load plans right now.</p>';
      });
  });

  function createToast() {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
      <div class="toast__content">
        <strong class="toast__title">VirtualSkyHost</strong>
        <div class="toast__message"></div>
      </div>
      <button type="button" class="toast__close" aria-label="Close notification">×</button>
    `;

    const closeButton = toast.querySelector('.toast__close');
    closeButton.addEventListener('click', () => {
      toast.classList.remove('is-visible');
    });

    document.body.appendChild(toast);
    return toast;
  }

  function showToast(element, message, options = {}) {
    if (!element) {
      return;
    }

    const messageElement = element.querySelector('.toast__message');
    if (messageElement) {
      messageElement.innerHTML = message;
    }

    element.classList.add('is-visible');

    if (!options.sticky) {
      setTimeout(() => {
        element.classList.remove('is-visible');
      }, 4000);
    }
  }
})();
