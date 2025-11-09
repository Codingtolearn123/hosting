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
        ]);
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
