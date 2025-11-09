(function () {
  const domainForm = document.querySelector('.domain-form');
  if (domainForm) {
    domainForm.addEventListener('submit', (event) => {
      event.preventDefault();
      const input = domainForm.querySelector('input');
      if (!input) return;
      const value = input.value.trim();
      const message = value
        ? `Searching availability for ${value}...`
        : 'Enter a domain name to search availability.';
      const toast = document.createElement('div');
      toast.className = 'toast';
      toast.textContent = message;
      document.body.appendChild(toast);
      requestAnimationFrame(() => {
        toast.classList.add('visible');
      });
      setTimeout(() => {
        toast.classList.remove('visible');
        setTimeout(() => toast.remove(), 300);
      }, 2600);
    });
  }

  const yearNode = document.getElementById('year');
  if (yearNode) {
    yearNode.textContent = new Date().getFullYear();
  }

  const navToggle = document.querySelector('.nav-toggle');
  const navMenu = document.getElementById('nav-menu');
  if (navToggle && navMenu) {
    navMenu.setAttribute('aria-expanded', navToggle.getAttribute('aria-expanded') ?? 'false');

    navToggle.addEventListener('click', () => {
      const expanded = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', String(!expanded));
      navMenu.setAttribute('aria-expanded', String(!expanded));
    });

    navMenu.addEventListener('click', (event) => {
      const target = event.target;
      if (target instanceof HTMLElement && target.closest('a')) {
        navToggle.setAttribute('aria-expanded', 'false');
        navMenu.setAttribute('aria-expanded', 'false');
      }
    });

    document.addEventListener('click', (event) => {
      if (!navMenu.hasAttribute('aria-expanded')) return;
      const expanded = navToggle.getAttribute('aria-expanded') === 'true';
      if (!expanded) return;
      const target = event.target;
      if (target instanceof Node && !navMenu.contains(target) && !navToggle.contains(target)) {
        navToggle.setAttribute('aria-expanded', 'false');
        navMenu.setAttribute('aria-expanded', 'false');
      }
    });
  }
})();
