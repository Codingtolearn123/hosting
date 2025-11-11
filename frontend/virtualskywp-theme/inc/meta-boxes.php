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
        case 'ai_tool':
            virtualskywp_save_ai_tool_meta($post_id);
            break;
        case 'testimonial':
            virtualskywp_save_testimonial_meta($post_id);
            break;
    }
}, 10, 2);

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
