(function () {
  const { apiFetch } = wp;

  function renderApp(container) {
    if (!container) return;

    const root = document.createElement('div');
    container.appendChild(root);

    const agents = JSON.parse(container.dataset.agents || '[]');

    function renderList(items) {
      root.innerHTML = '';
      const list = document.createElement('div');
      list.className = 'virtualsky-agent-list';
      items.forEach((agent) => {
        const card = document.createElement('div');
        card.className = 'virtualsky-agent-widget';
        card.innerHTML = `
          <h3 class="virtualsky-agent-name">${agent.name}</h3>
          <p class="virtualsky-agent-goal">${agent.goal || ''}</p>
          <code style="display:block; margin-top:8px;">[virtualskywp_agent id="${agent.id}"]</code>
        `;
        list.appendChild(card);
      });
      root.appendChild(list);
    }

    function renderForm() {
      const form = document.createElement('form');
      form.className = 'virtualsky-agent-form';
      form.innerHTML = `
        <h2>${wp.i18n.__('Create Agent', 'virtualsky-ai-builder')}</h2>
        <p class="description">${wp.i18n.__('Define agent details and click save to generate a shortcode.', 'virtualsky-ai-builder')}</p>
        <div class="virtualsky-agent-fields">
          <p><label>${wp.i18n.__('Agent Name', 'virtualsky-ai-builder')}<input type="text" name="name" required /></label></p>
          <p><label>${wp.i18n.__('Goal', 'virtualsky-ai-builder')}<input type="text" name="goal" /></label></p>
          <p><label>${wp.i18n.__('Tone', 'virtualsky-ai-builder')}<input type="text" name="tone" /></label></p>
          <p><label>${wp.i18n.__('Model', 'virtualsky-ai-builder')}<input type="text" name="model" placeholder="gpt-4o" /></label></p>
          <p><label>${wp.i18n.__('API Key Alias', 'virtualsky-ai-builder')}<input type="text" name="api_key" /></label></p>
          <p><label>${wp.i18n.__('Knowledge Base URL', 'virtualsky-ai-builder')}<input type="url" name="knowledge_base" /></label></p>
          <p><label>${wp.i18n.__('System Prompt', 'virtualsky-ai-builder')}<textarea name="prompt" rows="4"></textarea></label></p>
        </div>
        <button type="submit" class="button button-primary">${wp.i18n.__('Save Agent', 'virtualsky-ai-builder')}</button>
      `;

      form.addEventListener('submit', (event) => {
        event.preventDefault();
        const data = Object.fromEntries(new FormData(form));
        apiFetch({
          path: 'virtualsky/v1/agents',
          method: 'POST',
          data,
          headers: { 'X-WP-Nonce': VirtualSkyAgentBuilder.nonce },
        })
          .then((agent) => {
            agents.unshift(agent);
            renderList(agents);
            form.reset();
            wp.data
              .dispatch('core/notices')
              .createNotice('success', wp.i18n.__('Agent created successfully.', 'virtualsky-ai-builder'), {
                isDismissible: true,
              });
          })
          .catch((error) => {
            wp.data
              .dispatch('core/notices')
              .createNotice('error', error.message || wp.i18n.__('Failed to create agent.', 'virtualsky-ai-builder'), {
                isDismissible: true,
              });
          });
      });

      root.appendChild(form);
    }

    renderForm();
    renderList(agents);
  }

  document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('virtualsky-agent-app');
    renderApp(container);
  });
})();
