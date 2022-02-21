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
    <?php wp_nonce_field( 'tagfilters_metabox_page_save', '_tagfilters_metabox_nonce' ); ?>

    <fieldset id="tagfilters-categories">
        <legend>Categories</legend>
        <label>
            <input type="checkbox" name="tagfilters_categories">
            Category1
        </label>
        <?php
        $tagfilters_categories = get_categories(array('hide_empty'=>false));
        $tagfilters_selected_categories = get_post_meta(get_the_ID(), '_tagfilters_categories', true);
        foreach ($tagfilters_categories as $tagfilters_category) {
            $tagfilters_category_checked_string =
                in_array(strval($tagfilters_category->term_id), $tagfilters_selected_categories) ? 'checked' : '';
            echo <<<END
                <label>
                    <input type="checkbox" name="tagfilters_categories[]"  value="$tagfilters_category->term_id" $tagfilters_category_checked_string>
                    $tagfilters_category->name
                </label>
                END;
        }
        ?>
    </fieldset>

    <fieldset id="tagfilters-tags">
        <legend>Tags</legend>
        <?php
        $tagfilters_tags = get_tags(array('hide_empty'=>false));
        $tagfilters_selected_tags = get_post_meta(get_the_ID(), '_tagfilters_tags', true);
        if($tagfilters_selected_tags == '') $tagfilters_selected_tags = array();
        foreach ($tagfilters_tags as $tagfilters_tag) {
            $tagfilters_tag_checked_string =
                in_array(strval($tagfilters_tag->term_id), $tagfilters_selected_tags) ? 'checked' : '';
            echo <<<END
                <label>
                    <input name="tagfilters_selected_tags[]" value="$tagfilters_tag->term_id" $tagfilters_tag_checked_string>
                    $tagfilters_tag->name
                </label>
                END;
        }
        ?>
    </fieldset>
</div>
