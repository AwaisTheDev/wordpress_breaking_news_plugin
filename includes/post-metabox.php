<?php

/* adding meta-boxes */

add_action('load-post.php', 'ttbn_post_metabox_setup');
add_action('load-post-new.php', 'ttbn_post_metabox_setup');

/* Meta box setup function. */
function ttbn_post_metabox_setup()
{

    /* Add meta boxes on the 'add_meta_boxes' hook. */
    add_action('add_meta_boxes', 'ttbn_add_metaboxes');
    add_action('save_post', 'ttbn_save_metaboxes', 10, 2);

}

function ttbn_add_metaboxes()
{
    //add_meta_box($id, $title, $callback, $screen, $context, $priority, $callback_args)

    add_meta_box('ttbn_breaking_news_metabox', 'Breaking News', 'ttbn_metabox', 'post-new.php', 'side', "default");

}

function ttbn_metabox($post)
{

    /*Create a nonce for security */
    wp_nonce_field(basename(__FILE__), 'ttbn_breaking_news_metabox_nonce');
    ?>

<p>
    <label for="is-breaking-news"><?php _e("Make this post breaking news", 'ttbn');?></label>
    <input class="ml-10" type="checkbox" id="is-breaking-news" name="is-breaking-news" value="1"
        <?php checked(get_post_meta($post->ID, 'is-breaking-news', true), '1')?>>
</p>
<div class="breaking_news_data_wrap"
    style="display:<?php echo (get_post_meta($post->ID, 'is-breaking-news', true) == 1) ? 'Block' : 'none'; ?>">

    <p>
        <label for=" custom-title"><?php _e("Custom title", 'ttbn');?></label>
        <br />
        <input class="widefat" type="text" name="custom-title" id="custom-title"
            value="<?php echo esc_attr(get_post_meta($post->ID, 'custom-title', true)); ?>" />
    </p>

    <p>
        <label for="set-_da-date"><?php _e("Set expiration date", 'ttbn');?></label>
        <input class="ml-10" type="checkbox" id="set-expiration-date" name="set-expiration-date" value="1"
            <?php checked(get_post_meta($post->ID, 'set-expiration-date', true), '1')?>>
    </p>

    <div class="expiration-data-wrap"
        style="display:<?php echo (get_post_meta($post->ID, 'set-expiration-date', true) == 1) ? 'Block' : 'none'; ?>">
        <p>
            <label for="expiration-date"><?php _e("Expiration date", 'ttbn');?></label>
            <br />
            <input class="widefat" type="text" name="expiration-date" id="expiration-date"
                value="<?php echo esc_attr(get_post_meta($post->ID, 'expiration-date', true)); ?>" />
        </p>

        <p>
            <label for="expiration-time"><?php _e("Expiration time", 'ttbn');?></label>
            <br />
            <input class="widefat" type="text" name="expiration-time" id="expiration-time"
                value="<?php echo esc_attr(get_post_meta($post->ID, 'expiration-time', true)); ?>" />
        </p>
    </div>
</div>

<?php }

/* Save the meta box’s post metadata. */
function ttbn_save_metaboxes($post_id, $post)
{

    /* Verify the nonce before proceeding. */
    if (!isset($_POST['ttbn_breaking_news_metabox_nonce']) || !wp_verify_nonce($_POST['ttbn_breaking_news_metabox_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id)) {
        return $post_id;
    }

    /* Breaking News checkbox */
    $is_breaking_news_meta_key = 'is-breaking-news';
    $is_breaking_news_meta_value = (isset($_POST[$is_breaking_news_meta_key]) && $_POST[$is_breaking_news_meta_key] === "1") ? "1" : "0";
    update_post_meta($post_id, $is_breaking_news_meta_key, $is_breaking_news_meta_value);

    /* Cutom title input */
    $title_meta_key = 'custom-title';
    $title_meta_value = (isset($_POST[$title_meta_key]) ? $_POST[$title_meta_key] : "");
    update_post_meta($post_id, $title_meta_key, $title_meta_value);

    /* Expiration date checkbox */
    $set_expiration_date_meta_key = 'set-expiration-date';
    $set_expiration_date_meta_value = (isset($_POST[$set_expiration_date_meta_key]) && $_POST[$set_expiration_date_meta_key] === "1") ? "1" : "0";
    update_post_meta($post_id, $set_expiration_date_meta_key, $set_expiration_date_meta_value);

    /* Expiration date input */
    $expiration_date_meta_key = 'expiration-date';
    $expiration_date_meta_value = (isset($_POST[$expiration_date_meta_key]) ? $_POST[$expiration_date_meta_key] : "");
    update_post_meta($post_id, $expiration_date_meta_key, $expiration_date_meta_value);

    /* Expiration time input */
    $expiration_time_meta_key = 'expiration-time';
    $expiration_time_meta_value = (isset($_POST[$expiration_time_meta_key]) ? $_POST[$expiration_time_meta_key] : "");
    update_post_meta($post_id, $expiration_time_meta_key, $expiration_time_meta_value);

}