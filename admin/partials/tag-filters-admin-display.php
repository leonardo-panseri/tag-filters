<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Tag_Filters
 * @subpackage Tag_Filters/admin/partials
 */
if(!empty($_POST)) {
    if(tagfilters_admin_validate_data()) {
        tagfilters_admin_create_new_post();
    } else {
        error_log('POST data for creation of new TagFilters post not valid: ' . json_encode($_POST));
    }
}

function tagfilters_admin_validate_data(): bool
{
    if(!current_user_can('manage_options')) return false;

    $keys_existence = array_key_exists('title', $_POST) &&
        array_key_exists('category', $_POST) &&
        array_key_exists('selected_tags', $_POST);
    if(!$keys_existence) return false;
    if(!is_numeric($_POST['category'])) return false;
    if(!is_array($_POST['selected_tags'])) return false;
    foreach ($_POST['selected_tags'] as $tag) {
        if(!is_numeric($tag)) return false;
    }

    return true;
}
$tagfilters_redirect_post_url = null;
function tagfilters_admin_create_new_post() {
    $post_id = wp_insert_post(array(
        'post_type' => 'tagfilters_page',
        'post_title' => sanitize_title($_POST['title'], 'New TagFilters Page'),
        'post_status' => 'publish',
    ));

    if($post_id) {
        add_post_meta($post_id, 'category', $_POST['category']);
        add_post_meta($post_id, 'filter_tags', $_POST['selected_tags']);
        global $tagfilters_redirect_post_url;
        $tagfilters_redirect_post_url = get_permalink($post_id);
    } else {
        error_log('Cannot create new TagFilters post with options ' . json_encode($_POST));
    }
}
?>
<?php if(isset($tagfilters_redirect_post_url)) { ?>
<script type="text/javascript">
    window.location.replace(<?php echo $tagfilters_redirect_post_url ?>)
</script>
<?php exit; } ?>


<div class="wrap">
    <h1>TagFilters Options</h1>
    <h3>New</h3>
    <form method="post" id="tagfilters-new-form">
        <label>
            Title
            <input type="text" name="title">
        </label>
        <br/>
        <label>
            Category
            <select name="category">
                <?php
                $categories = get_categories(array('hide_empty'=>false));
                foreach ($categories as $category) {
                    echo "<option value='{$category->term_id}'>{$category->name}</option>";
                }
                ?>
            </select>
        </label>
        <br/>
        <label>
            Tags
            <select name="tags" id="tagfilters-available-tags">
                <?php
                $tags = get_tags(array('hide_empty'=>false));
                foreach ($tags as $tag) {
                    echo "<option value='{$tag->term_id}'>{$tag->name}</option>";
                }
                ?>
            </select>
        </label>
        <button type="button" id="tagfilters-tags-add-btn">&plus;</button>
        <ul id="tagfilters-tags-list">
        </ul>
        <br/>
        <button type="submit">Add</button>
    </form>

    <br/>
    <h3>Available</h3>
    <label for="tagfilters-available-pages"></label>
    <select id="tagfilters-available-pages">
        <?php
        $pages = get_posts(array(
            'post_type' => 'tagfilters_page',
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));
        foreach ($pages as $page) {
            echo "<option value='{$page->post_name}'>{$page->post_title}</option>";
        }
        ?>
    </select>
</div>

