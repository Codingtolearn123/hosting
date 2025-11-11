<?php
/**
 * Custom meta boxes for VirtualSkyWP entities.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

add_action('add_meta_boxes', static function (): void {
    add_meta_box(
        'virtualskywp_hosting_plan_details',
        __('Plan Details', 'virtualskywp'),
        'virtualskywp_render_hosting_plan_meta_box',
        'hosting_plan',
        'normal',
        'default'
    );

    add_meta_box(
        'virtualskywp_ai_tool_details',
        __('AI Tool Settings', 'virtualskywp'),
        'virtualskywp_render_ai_tool_meta_box',
        'ai_tool',
        'normal',
        'default'
    );

    add_meta_box(
        'virtualskywp_testimonial_details',
        __('Testimonial Details', 'virtualskywp'),
        'virtualskywp_render_testimonial_meta_box',
        'testimonial',
        'normal',
        'default'
    );
});

add_action('save_post', static function (int $post_id, WP_Post $post): void {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    switch ($post->post_type) {
        case 'hosting_plan':
            virtualskywp_save_hosting_plan_meta($post_id);
            break;
        case 'ai_tool':
            virtualskywp_save_ai_tool_meta($post_id);
            break;
        case 'testimonial':
            virtualskywp_save_testimonial_meta($post_id);
            break;
    }
}, 10, 2);

function virtualskywp_render_hosting_plan_meta_box(\WP_Post $post): void
{
    wp_nonce_field('virtualskywp_hosting_plan_meta', 'virtualskywp_hosting_plan_meta_nonce');

    $fields = [
        'price_monthly' => __('Monthly Price', 'virtualskywp'),
        'price_yearly' => __('Yearly Price', 'virtualskywp'),
        'promo_price' => __('Promo (First Month) Price', 'virtualskywp'),
        'whmcs_link' => __('WHMCS Product URL', 'virtualskywp'),
        'n8n_webhook' => __('n8n Webhook URL', 'virtualskywp'),
        'badge_text' => __('Badge Text', 'virtualskywp'),
    ];

    $bool_fields = [
        'highlighted' => __('Mark as Best Value', 'virtualskywp'),
        'free_domain' => __('Includes Free Domain First Year', 'virtualskywp'),
        'ai_ready' => __('AI Ready Infrastructure', 'virtualskywp'),
    ];

    $features = get_post_meta($post->ID, '_virtualskywp_features', true);
    $feature_lines = is_array($features) ? implode("\n", $features) : '';
    ?>
    <div class="virtualskywp-metabox">
        <div class="virtualskywp-metabox__grid">
            <?php foreach ($fields as $field => $label) :
                $value = get_post_meta($post->ID, '_virtualskywp_' . $field, true);
                ?>
                <p>
                    <label for="virtualskywp_<?php echo esc_attr($field); ?>"><?php echo esc_html($label); ?></label><br />
                    <input type="text" name="virtualskywp_<?php echo esc_attr($field); ?>" id="virtualskywp_<?php echo esc_attr($field); ?>" value="<?php echo esc_attr((string) $value); ?>" class="widefat" />
                </p>
            <?php endforeach; ?>
        </div>
        <fieldset>
            <legend><?php esc_html_e('Features (one per line)', 'virtualskywp'); ?></legend>
            <textarea name="virtualskywp_features" rows="6" class="widefat"><?php echo esc_textarea($feature_lines); ?></textarea>
        </fieldset>
        <fieldset class="virtualskywp-metabox__checks">
            <?php foreach ($bool_fields as $field => $label) :
                $checked = (bool) get_post_meta($post->ID, '_virtualskywp_' . $field, true);
                ?>
                <label>
                    <input type="checkbox" name="virtualskywp_<?php echo esc_attr($field); ?>" value="1" <?php checked($checked, true); ?> />
                    <?php echo esc_html($label); ?>
                </label><br />
            <?php endforeach; ?>
        </fieldset>
    </div>
    <?php
}

function virtualskywp_save_hosting_plan_meta(int $post_id): void
{
    if (!isset($_POST['virtualskywp_hosting_plan_meta_nonce']) || !wp_verify_nonce($_POST['virtualskywp_hosting_plan_meta_nonce'], 'virtualskywp_hosting_plan_meta')) {
        return;
    }

    $fields = ['price_monthly', 'price_yearly', 'promo_price', 'whmcs_link', 'n8n_webhook', 'badge_text'];

    foreach ($fields as $field) {
        $key = '_virtualskywp_' . $field;
        $value = $_POST['virtualskywp_' . $field] ?? '';

        if (in_array($field, ['whmcs_link', 'n8n_webhook'], true)) {
            update_post_meta($post_id, $key, esc_url_raw((string) $value));
        } else {
            update_post_meta($post_id, $key, sanitize_text_field((string) $value));
        }
    }

    $bool_fields = ['highlighted', 'free_domain', 'ai_ready'];

    foreach ($bool_fields as $field) {
        $key = '_virtualskywp_' . $field;
        update_post_meta($post_id, $key, isset($_POST['virtualskywp_' . $field]) ? '1' : '');
    }

    $features_raw = isset($_POST['virtualskywp_features']) ? wp_unslash((string) $_POST['virtualskywp_features']) : '';
    $features = array_filter(array_map('trim', explode("\n", $features_raw)));
    update_post_meta($post_id, '_virtualskywp_features', $features);
}

function virtualskywp_render_ai_tool_meta_box(\WP_Post $post): void
{
    wp_nonce_field('virtualskywp_ai_tool_meta', 'virtualskywp_ai_tool_meta_nonce');

    $fields = [
        'cta_label' => __('Button Label', 'virtualskywp'),
        'tool_link' => __('Tool URL', 'virtualskywp'),
    ];
    ?>
    <div class="virtualskywp-metabox">
        <?php foreach ($fields as $field => $label) :
            $value = get_post_meta($post->ID, '_virtualskywp_' . $field, true);
            ?>
            <p>
                <label for="virtualskywp_<?php echo esc_attr($field); ?>"><?php echo esc_html($label); ?></label><br />
                <input type="text" name="virtualskywp_<?php echo esc_attr($field); ?>" id="virtualskywp_<?php echo esc_attr($field); ?>" value="<?php echo esc_attr((string) $value); ?>" class="widefat" />
            </p>
        <?php endforeach; ?>
        <p>
            <label for="virtualskywp_tool_type"><?php esc_html_e('Tool Category', 'virtualskywp'); ?></label><br />
            <input type="text" name="virtualskywp_tool_type" id="virtualskywp_tool_type" value="<?php echo esc_attr((string) get_post_meta($post->ID, '_virtualskywp_tool_type', true)); ?>" class="widefat" />
        </p>
    </div>
    <?php
}

function virtualskywp_save_ai_tool_meta(int $post_id): void
{
    if (!isset($_POST['virtualskywp_ai_tool_meta_nonce']) || !wp_verify_nonce($_POST['virtualskywp_ai_tool_meta_nonce'], 'virtualskywp_ai_tool_meta')) {
        return;
    }

    $fields = ['cta_label', 'tool_link', 'tool_type'];

    foreach ($fields as $field) {
        $key = '_virtualskywp_' . $field;
        $value = $_POST['virtualskywp_' . $field] ?? '';
        if ($field === 'tool_link') {
            update_post_meta($post_id, $key, esc_url_raw((string) $value));
        } else {
            update_post_meta($post_id, $key, sanitize_text_field((string) $value));
        }
    }
}

function virtualskywp_render_testimonial_meta_box(\WP_Post $post): void
{
    wp_nonce_field('virtualskywp_testimonial_meta', 'virtualskywp_testimonial_meta_nonce');
    ?>
    <div class="virtualskywp-metabox">
        <p>
            <label for="virtualskywp_author_role"><?php esc_html_e('Role / Company', 'virtualskywp'); ?></label><br />
            <input type="text" name="virtualskywp_author_role" id="virtualskywp_author_role" value="<?php echo esc_attr((string) get_post_meta($post->ID, '_virtualskywp_author_role', true)); ?>" class="widefat" />
        </p>
        <p>
            <label for="virtualskywp_rating"><?php esc_html_e('Rating (1-5)', 'virtualskywp'); ?></label><br />
            <input type="number" min="1" max="5" name="virtualskywp_rating" id="virtualskywp_rating" value="<?php echo esc_attr((string) get_post_meta($post->ID, '_virtualskywp_rating', true)); ?>" class="small-text" />
        </p>
    </div>
    <?php
}

function virtualskywp_save_testimonial_meta(int $post_id): void
{
    if (!isset($_POST['virtualskywp_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['virtualskywp_testimonial_meta_nonce'], 'virtualskywp_testimonial_meta')) {
        return;
    }

    $role = $_POST['virtualskywp_author_role'] ?? '';
    $rating = $_POST['virtualskywp_rating'] ?? '';

    update_post_meta($post_id, '_virtualskywp_author_role', sanitize_text_field((string) $role));
    update_post_meta($post_id, '_virtualskywp_rating', max(1, min(5, (int) $rating)));
}
