<?php

/**
 * Provide a view for the custom meta box in the TagFilters Page editor.
 *
 * @since      1.0.0
 *
 * @package    Tag_Filters
 * @subpackage Tag_Filters/admin/partials
 */
?>

<div id="tagfilters-meta-box">
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
</div>
