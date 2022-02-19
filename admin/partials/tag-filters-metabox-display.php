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
        <select name="tagfilters_category">
            <?php
            $tagfilters_categories = get_categories(array('hide_empty'=>false));
            $tagfilters_selected_category = get_post_meta(get_the_ID(), 'tagfilters_category', true);
            foreach ($tagfilters_categories as $tagfilters_category) {
                echo "<option value='{$tagfilters_category->term_id}'" .
                    ($tagfilters_selected_category == strval($tagfilters_category->term_id) ? " selected" : "") .
                    ">{$tagfilters_category->name}</option>";
            }
            ?>
        </select>
    </label>
    <br/>
    <label>
        Tags
        <select id="tagfilters-available-tags">
            <?php
            $tagfilters_tags = get_tags(array('hide_empty'=>false));
            $tagfilters_selected_tags = get_post_meta(get_the_ID(), 'tagfilters_tags');
            foreach ($tagfilters_tags as $tagfilters_tag) {
                echo "<option value='{$tagfilters_tag->term_id}' data-used='" .
                    (in_array(strval($tagfilters_tag->term_id), $tagfilters_selected_tags) ? 'true' : 'false') .
                    "'>{$tagfilters_tag->name}</option>";
            }
            ?>
        </select>
    </label>
    <button type="button" id="tagfilters-tags-add-btn">&plus;</button>
    <ul id="tagfilters-tags-list">
    </ul>
</div>
