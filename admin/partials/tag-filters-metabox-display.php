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
    <!-- <div class="components-form-token-field" tabindex="-1">
        <label for="components-form-token-input-2" class="components-form-token-field__label">Add New Tag</label>
        <div class="components-form-token-field__input-container" tabindex="-1">
            <input id="components-form-token-input-2" type="text" autocomplete="off" class="components-form-token-field__input" role="combobox" aria-expanded="false" aria-autocomplete="list" aria-describedby="components-form-token-suggestions-howto-2" value="">
        </div>
        <p id="components-form-token-suggestions-howto-2" class="components-form-token-field__help">Separate with commas or the Enter key.</p>
    </div> -->
    <h5><label for="tagfilters_category">Category</label></h5>
    <select id="tagfilters_category" name="tagfilters_category">
        <?php
        $tagfilters_categories = get_categories(array('hide_empty'=>false));
        $tagfilters_selected_category = get_post_meta(get_the_ID(), '_tagfilters_category', true);
        foreach ($tagfilters_categories as $tagfilters_category) {
            echo "<option value='{$tagfilters_category->term_id}'" .
                ($tagfilters_selected_category == strval($tagfilters_category->term_id) ? " selected" : "") .
                ">{$tagfilters_category->name}</option>";
        }
        ?>
    </select>
    <br/>
    <label>
        Tags
        <select id="tagfilters-available-tags">
            <?php
            $tagfilters_tags = get_tags(array('hide_empty'=>false));
            $tagfilters_selected_tags = get_post_meta(get_the_ID(), '_tagfilters_tags', true);
            if($tagfilters_selected_tags == '') $tagfilters_selected_tags = array();
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
