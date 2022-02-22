<?php

/**
 * Provide a public-facing view for the tagfilters page post type
 *
 * @since      1.0.0
 *
 * @package    Tag_Filters
 * @subpackage Tag_Filters/public/partials
 */
?>

<?php get_header() ?>

<main class="wp-block-group">
    <div class="wp-block-group">
        <?php the_title() ?>

        <?php the_post_thumbnail('full'); ?>

        <hr class="wp-block-separator alignwide is-style-wide"/>
    </div>

    <div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>

    <?php
    echo <<<END
        <div>
            <p>Test p</p>
        </div>
        END;

    ?>

    <div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
</main>

<?php get_footer() ?>