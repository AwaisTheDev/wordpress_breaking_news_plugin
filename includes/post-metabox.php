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
    /**
     * This function will create a new netabox on the post page with title "Breaking News"
     */

    //add_meta_box($id, $title, $callback, $screen, $context, $priority, $callback_args)
    add_meta_box('ttbn_breaking_news_metabox', 'Breaking News', 'ttbn_metabox', 'post-new.php', 'side', "default");

}

function ttbn_metabox($post)
{

    /**
     * Create a nonce for security and we will verify it while saving the post
     */
    wp_nonce_field(basename(__FILE__), 'ttbn_breaking_news_metabox_nonce');
    //echo get_post_meta($post->ID, 'is-breaking-news', true);
    ?>

<!-- Is breaking news start -->
<p>
    <label for="is-breaking-news"><?php _e("Make this post breaking news", 'ttbn');?></label>
    <input class="ml-10" type="checkbox" id="is-breaking-news" name="is-breaking-news" value="1"
        <?php checked(get_post_meta($post->ID, 'is-breaking-news', true), '1')?>>
</p>
<div class="breaking_news_data_wrap"
    style="display:<?php echo (get_post_meta($post->ID, 'is-breaking-news', true) == 1) ? 'Block' : 'none'; ?>">

    <!-- Custom title start -->
    <p>
        <label for=" custom-title"><?php _e("Custom title", 'ttbn');?></label>
        <br />
        <input class="widefat" type="text" name="custom-title" id="custom-title"
            value="<?php echo esc_attr(get_post_meta($post->ID, 'custom-title', true)); ?>" />
    </p>

    <!-- Expiration date checkbox start -->
    <p>
        <label for="set-_da-date"><?php _e("Set expiration date", 'ttbn');?></label>
        <input class="ml-10" type="checkbox" id="set-expiration-date" name="set-expiration-date" value="1"
            <?php checked(get_post_meta($post->ID, 'set-expiration-date', true), '1')?>>
    </p>

    <div class="expiration-data-wrap"
        style="display:<?php echo (get_post_meta($post->ID, 'set-expiration-date', true) == 1) ? 'Block' : 'none'; ?>">

        <!-- Expiration date start -->
        <p>
            <label for="expiration-date"><?php _e("Expiration date (dd-mm-yyyy)", 'ttbn');?></label>
            <br />
            <input class="widefat" type="text" name="expiration-date" id="expiration-date" autocomplete="off"
                value="<?php echo esc_attr(get_post_meta($post->ID, 'expiration-date', true)); ?>" />
        </p>

        <!-- Expiration time start-->
        <p>
            <label for="expiration-time"><?php _e("Expiration time (hh-mm) 24 hour format", 'ttbn');?></label>
            <br />
            <input class="widefat" type="text" name="expiration-time" id="expiration-time" autocomplete="off"
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

    /**
     * Check if the post is marked as breaking news and then search all the posts which are set as breaking news.
     * Then set these unmark these posts as breaking news by setting the meta vale "is-breaking-news" to 0
     */
    if (isset($_POST['is-breaking-news']) && $_POST['is-breaking-news'] == "1") {

        $old_value = get_post_meta($post_id, 'is-breaking-news', true);
        $new_value = $_POST['is-breaking-news'];

        if ($old_value != $new_value) {

            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'is-breaking-news',
                        'value' => '1',
                        'compare' => 'LIKE',
                    ),
                ),
            );

            $breaking_news = new WP_Query($args);

            if ($breaking_news->have_posts()) {
                while ($breaking_news->have_posts()) {
                    $breaking_news->the_post();

                    update_post_meta(get_the_ID(), 'is-breaking-news', '0'); //Update meta value to 0

                }
            }
        }
    }

    /**
     * Check if expiration date is changed
     * if date is changed create a new event
     */
    if (isset($_POST['set-expiration-date']) && $_POST['set-expiration-date'] == "1") {
        $old_expiration_date = get_post_meta($post, 'expiration-date', true);
        $old_expiration_time = get_post_meta($post, 'expiration-time', true);

        $new_expiration_date = $_POST['expiration-date'];
        $new_expiration_time = $_POST['expiration-time'];

        if ($new_expiration_date != $old_expiration_date || $new_expiration_time != $old_expiration_time) {

            if (function_exists('ttbn_expire_breaking_news')) {

                if (!wp_next_scheduled('expire_breaking_news')) {

                    $hook_timestamp = strtotime($new_expiration_date . " " . $new_expiration_time . wp_timezone_string());

                    wp_schedule_single_event($hook_timestamp, 'expire_breaking_news', array($post_id));
                }

            }

        }
    }

    /**
     * Update post meta with newly submitted values.
     */

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

//this is a cron job to automatically unmark breaking news and reset values
add_action('expire_breaking_news', 'ttbn_expire_breaking_news');
function ttbn_expire_breaking_news($post_id)
{
    update_post_meta($post_id, 'is-breaking-news', '0');
    update_post_meta($post_id, 'set-expiration-date', '0');
    update_post_meta($post_id, 'expiration-date', '');
    update_post_meta($post_id, 'expiration-time', '');
}