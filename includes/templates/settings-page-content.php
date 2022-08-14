<div class="wrap">


    <h1>
        <?php echo esc_html(get_admin_page_title()) ?>
    </h1>

    <?php settings_errors()?>

    <form action="options.php" method="post">

        <?php settings_fields('ttbn_settings_group')?>
        <?php do_settings_sections('ttbn_breaking_news');?>
        <?php submit_button("Save")?>

    </form>
</div>