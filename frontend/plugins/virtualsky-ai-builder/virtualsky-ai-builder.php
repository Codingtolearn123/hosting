<?php
/**
 * Plugin Name: VirtualSky AI Builder
 * Description: Admin interface for creating AI agents and embedding previews within the Virtual Sky platform.
 * Version: 1.0.0
 * Author: Virtual Sky Team
 * Text Domain: virtualsky-ai-builder
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

final class VirtualSky_Agent_Builder
{
    public const CPT = 'virtualsky_agent';
    private const OPTION_KEY = 'virtualsky_ai_builder_settings';

    private static ?self $instance = null;

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('init', [$this, 'register_post_type']);
        add_action('add_meta_boxes', [$this, 'register_meta_boxes']);
        add_action('save_post', [$this, 'save_agent_meta'], 10, 2);
        add_action('admin_menu', [$this, 'register_builder_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_shortcode('virtualskywp_agent', [$this, 'render_agent_shortcode']);
        add_shortcode('virtualskywp_agent_preview', [$this, 'render_preview_shortcode']);
        add_action('rest_api_init', [$this, 'register_rest_routes']);
    }

    public function register_post_type(): void
    {
        register_post_type(self::CPT, [
            'labels' => [
                'name' => __('AI Agents', 'virtualsky-ai-builder'),
                'singular_name' => __('AI Agent', 'virtualsky-ai-builder'),
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'supports' => ['title', 'editor'],
        ]);
    }

    public function register_meta_boxes(): void
    {
        add_meta_box(
            'virtualsky_agent_settings',
            __('Agent Settings', 'virtualsky-ai-builder'),
            [$this, 'render_agent_meta_box'],
            self::CPT,
            'normal',
            'default'
        );
    }

    public function render_agent_meta_box(\WP_Post $post): void
    {
        wp_nonce_field('virtualsky_agent_meta', 'virtualsky_agent_meta_nonce');

        $fields = [
            'model' => __('Default Model (gpt-4, claude-3, etc.)', 'virtualsky-ai-builder'),
            'tone' => __('Tone (friendly, technical, playful)', 'virtualsky-ai-builder'),
            'goal' => __('Primary Goal', 'virtualsky-ai-builder'),
            'api_key' => __('API Key Alias', 'virtualsky-ai-builder'),
            'knowledge_base' => __('Knowledge Base URL', 'virtualsky-ai-builder'),
        ];
        ?>
        <div class="virtualsky-agent-fields">
            <?php foreach ($fields as $key => $label) :
                $value = get_post_meta($post->ID, '_virtualsky_agent_' . $key, true);
                ?>
                <p>
                    <label for="virtualsky_agent_<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label><br />
                    <input type="text" class="widefat" name="virtualsky_agent_<?php echo esc_attr($key); ?>" id="virtualsky_agent_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr((string) $value); ?>" />
                </p>
            <?php endforeach; ?>
            <p>
                <label for="virtualsky_agent_prompt"><?php esc_html_e('System Prompt', 'virtualsky-ai-builder'); ?></label><br />
                <textarea class="widefat" rows="6" name="virtualsky_agent_prompt" id="virtualsky_agent_prompt"><?php echo esc_textarea((string) get_post_meta($post->ID, '_virtualsky_agent_prompt', true)); ?></textarea>
            </p>
        </div>
        <?php
    }

    public function save_agent_meta(int $post_id, \WP_Post $post): void
    {
        if ($post->post_type !== self::CPT) {
            return;
        }

        if (!isset($_POST['virtualsky_agent_meta_nonce']) || !wp_verify_nonce($_POST['virtualsky_agent_meta_nonce'], 'virtualsky_agent_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $keys = ['model', 'tone', 'goal', 'api_key', 'knowledge_base', 'prompt'];

        foreach ($keys as $key) {
            $value = $_POST['virtualsky_agent_' . $key] ?? '';
            update_post_meta($post_id, '_virtualsky_agent_' . $key, sanitize_textarea_field((string) $value));
        }
    }

    public function register_builder_page(): void
    {
        add_menu_page(
            __('AI Agent Builder', 'virtualsky-ai-builder'),
            __('AI Agent Builder', 'virtualsky-ai-builder'),
            'edit_posts',
            'virtualsky-agent-builder',
            [$this, 'render_builder_page'],
            'dashicons-art',
            56
        );

        add_submenu_page(
            'virtualsky-agent-builder',
            __('All Agents', 'virtualsky-ai-builder'),
            __('All Agents', 'virtualsky-ai-builder'),
            'edit_posts',
            'edit.php?post_type=' . self::CPT
        );

        add_submenu_page(
            'virtualsky-agent-builder',
            __('API Settings', 'virtualsky-ai-builder'),
            __('API Settings', 'virtualsky-ai-builder'),
            'manage_options',
            'virtualsky-agent-builder-settings',
            [$this, 'render_settings_page']
        );
    }

    public function render_builder_page(): void
    {
        $agents = get_posts([
            'post_type' => self::CPT,
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
        ?>
        <div class="wrap virtualsky-agent-builder">
            <h1><?php esc_html_e('AI Agent Builder', 'virtualsky-ai-builder'); ?></h1>
            <p class="description"><?php esc_html_e('Create reusable AI agents and embed them with shortcodes or the Gutenberg block.', 'virtualsky-ai-builder'); ?></p>
            <div id="virtualsky-agent-app" data-agents="<?php echo esc_attr(wp_json_encode(array_map([$this, 'format_agent'], $agents))); ?>"></div>
        </div>
        <?php
    }

    public function render_settings_page(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        ?>
        <div class="wrap virtualsky-agent-builder">
            <h1><?php esc_html_e('AI Provider Settings', 'virtualsky-ai-builder'); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields(self::OPTION_KEY);
                do_settings_sections(self::OPTION_KEY);
                submit_button();
                ?>
            </form>
            <p class="description"><?php esc_html_e('The stored API key is used for agent previews and custom REST actions. It never renders on the public site.', 'virtualsky-ai-builder'); ?></p>
        </div>
        <?php
    }

    public function sanitize_settings($input): array
    {
        $defaults = [
            'provider' => 'openai',
            'api_key' => '',
            'base_url' => 'https://api.openai.com/v1',
            'default_model' => 'gpt-4o-mini',
        ];

        if (!is_array($input)) {
            return $defaults;
        }

        $settings = $defaults;

        if (isset($input['provider'])) {
            $settings['provider'] = sanitize_key((string) $input['provider']);
        }

        if (isset($input['api_key'])) {
            $settings['api_key'] = sanitize_text_field((string) $input['api_key']);
        }

        if (isset($input['base_url'])) {
            $settings['base_url'] = esc_url_raw((string) $input['base_url']);
        }

        if (isset($input['default_model'])) {
            $settings['default_model'] = sanitize_text_field((string) $input['default_model']);
        }

        return $settings;
    }

    public function render_select_field(array $args): void
    {
        $settings = get_option(self::OPTION_KEY, []);
        $key = $args['key'];
        $value = $settings[$key] ?? '';
        $options = $args['options'] ?? [];

        echo '<select name="' . esc_attr(self::OPTION_KEY . '[' . $key . ']') . '">';

        foreach ($options as $option_value => $label) {
            printf('<option value="%1$s" %2$s>%3$s</option>', esc_attr($option_value), selected($value, $option_value, false), esc_html($label));
        }

        echo '</select>';
    }

    public function render_input_field(array $args): void
    {
        $settings = get_option(self::OPTION_KEY, []);
        $key = $args['key'];
        $type = $args['type'] ?? 'text';
        $value = $settings[$key] ?? '';
        $description = $args['description'] ?? '';

        printf('<input type="%1$s" name="%2$s[%3$s]" value="%4$s" class="regular-text" autocomplete="off" />', esc_attr($type), esc_attr(self::OPTION_KEY), esc_attr($key), esc_attr((string) $value));

        if ($description) {
            printf('<p class="description">%s</p>', esc_html($description));
        }
    }

    private function get_api_settings(): array
    {
        $settings = get_option(self::OPTION_KEY, []);

        return [
            'provider' => sanitize_key($settings['provider'] ?? 'openai'),
            'baseUrl' => esc_url_raw($settings['base_url'] ?? 'https://api.openai.com/v1'),
            'defaultModel' => sanitize_text_field($settings['default_model'] ?? 'gpt-4o-mini'),
            'hasKey' => !empty($settings['api_key']),
        ];
    }

    public function enqueue_admin_assets(string $hook_suffix): void
    {
        if (strpos($hook_suffix, 'virtualsky-agent-builder') === false) {
            return;
        }

        wp_enqueue_style(
            'virtualsky-agent-builder',
            plugin_dir_url(__FILE__) . 'assets/admin.css',
            [],
            '1.0.0'
        );

        wp_enqueue_script(
            'virtualsky-agent-builder',
            plugin_dir_url(__FILE__) . 'assets/admin.js',
            ['wp-element', 'wp-api-fetch', 'wp-i18n', 'wp-data'],
            '1.0.0',
            true
        );

        wp_localize_script('virtualsky-agent-builder', 'VirtualSkyAgentBuilder', [
            'restUrl' => esc_url_raw(rest_url('virtualsky/v1/agents')),
            'nonce' => wp_create_nonce('wp_rest'),
            'api' => $this->get_api_settings(),
        ]);
    }

    public function register_settings(): void
    {
        register_setting(self::OPTION_KEY, self::OPTION_KEY, [
            'type' => 'array',
            'sanitize_callback' => [$this, 'sanitize_settings'],
            'default' => [
                'provider' => 'openai',
                'api_key' => '',
                'base_url' => 'https://api.openai.com/v1',
                'default_model' => 'gpt-4o-mini',
            ],
        ]);

        add_settings_section(
            'virtualsky_ai_provider',
            __('AI Provider', 'virtualsky-ai-builder'),
            static function (): void {
                echo '<p class="description">' . esc_html__('Manage your OpenAI-compatible credentials so agents can call the correct API without exposing raw keys in each agent record.', 'virtualsky-ai-builder') . '</p>';
            },
            self::OPTION_KEY
        );

        add_settings_field(
            'provider',
            __('Provider', 'virtualsky-ai-builder'),
            [$this, 'render_select_field'],
            self::OPTION_KEY,
            'virtualsky_ai_provider',
            [
                'key' => 'provider',
                'options' => [
                    'openai' => __('OpenAI', 'virtualsky-ai-builder'),
                    'azure' => __('Azure OpenAI', 'virtualsky-ai-builder'),
                    'custom' => __('Custom Compatible API', 'virtualsky-ai-builder'),
                ],
            ]
        );

        add_settings_field(
            'api_key',
            __('API Key', 'virtualsky-ai-builder'),
            [$this, 'render_input_field'],
            self::OPTION_KEY,
            'virtualsky_ai_provider',
            [
                'key' => 'api_key',
                'type' => 'password',
            ]
        );

        add_settings_field(
            'base_url',
            __('Base URL', 'virtualsky-ai-builder'),
            [$this, 'render_input_field'],
            self::OPTION_KEY,
            'virtualsky_ai_provider',
            [
                'key' => 'base_url',
                'type' => 'text',
                'description' => __('Override when using Azure OpenAI or a self-hosted compatible endpoint.', 'virtualsky-ai-builder'),
            ]
        );

        add_settings_field(
            'default_model',
            __('Default Model', 'virtualsky-ai-builder'),
            [$this, 'render_input_field'],
            self::OPTION_KEY,
            'virtualsky_ai_provider',
            [
                'key' => 'default_model',
                'type' => 'text',
                'description' => __('Used whenever an agent is missing a model value.', 'virtualsky-ai-builder'),
            ]
        );
    }

    public function register_rest_routes(): void
    {
        register_rest_route('virtualsky/v1', '/agents', [
            [
                'methods' => 'GET',
                'callback' => [$this, 'rest_get_agents'],
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ],
            [
                'methods' => 'POST',
                'callback' => [$this, 'rest_create_agent'],
                'permission_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ],
        ]);
    }

    public function rest_get_agents(): \WP_REST_Response
    {
        $agents = get_posts([
            'post_type' => self::CPT,
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        return new \WP_REST_Response(array_map([$this, 'format_agent'], $agents));
    }

    public function rest_create_agent(\WP_REST_Request $request): \WP_REST_Response
    {
        $params = $request->get_json_params();
        $title = sanitize_text_field($params['name'] ?? __('New Agent', 'virtualsky-ai-builder'));
        $content = sanitize_textarea_field($params['description'] ?? '');

        $post_id = wp_insert_post([
            'post_type' => self::CPT,
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
        ], true);

        if (is_wp_error($post_id)) {
            return new \WP_REST_Response(['error' => $post_id->get_error_message()], 400);
        }

        $meta_keys = ['model', 'tone', 'goal', 'api_key', 'knowledge_base', 'prompt'];

        foreach ($meta_keys as $key) {
            if (isset($params[$key])) {
                update_post_meta($post_id, '_virtualsky_agent_' . $key, sanitize_textarea_field((string) $params[$key]));
            }
        }

        $agent = get_post($post_id);

        return new \WP_REST_Response($this->format_agent($agent));
    }

    public function render_agent_shortcode(array $atts = []): string
    {
        $atts = shortcode_atts([
            'id' => 0,
        ], $atts);

        $agent = get_post((int) $atts['id']);

        if (!$agent || $agent->post_type !== self::CPT) {
            return '';
        }

        $data = $this->format_agent($agent);

        ob_start();
        ?>
        <div class="virtualsky-agent-widget" data-agent='<?php echo esc_attr(wp_json_encode($data)); ?>'>
            <h3 class="virtualsky-agent-name"><?php echo esc_html($data['name']); ?></h3>
            <p class="virtualsky-agent-goal"><?php echo esc_html($data['goal']); ?></p>
            <button type="button" class="virtualsky-agent-launch" data-agent-launch><?php esc_html_e('Chat with Agent', 'virtualsky-ai-builder'); ?></button>
        </div>
        <?php
        return (string) ob_get_clean();
    }

    public function render_preview_shortcode(): string
    {
        $agents = get_posts([
            'post_type' => self::CPT,
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        if (empty($agents)) {
            return '<p>' . esc_html__('Create your first agent to see a preview.', 'virtualsky-ai-builder') . '</p>';
        }

        return $this->render_agent_shortcode(['id' => $agents[0]->ID]);
    }

    private function format_agent(\WP_Post $post): array
    {
        return [
            'id' => $post->ID,
            'name' => get_the_title($post),
            'description' => wp_strip_all_tags($post->post_content),
            'model' => get_post_meta($post->ID, '_virtualsky_agent_model', true),
            'tone' => get_post_meta($post->ID, '_virtualsky_agent_tone', true),
            'goal' => get_post_meta($post->ID, '_virtualsky_agent_goal', true),
            'api_key' => get_post_meta($post->ID, '_virtualsky_agent_api_key', true),
            'knowledge_base' => get_post_meta($post->ID, '_virtualsky_agent_knowledge_base', true),
            'prompt' => get_post_meta($post->ID, '_virtualsky_agent_prompt', true),
        ];
    }
}

VirtualSky_Agent_Builder::instance();
