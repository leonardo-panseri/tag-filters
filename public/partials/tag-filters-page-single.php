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

<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main"} -->
<main class="wp-block-group"><!-- wp:group {"layout":{"inherit":true}} -->
    <div class="wp-block-group"><!-- wp:post-title {"level":1,"align":"wide","style":{"spacing":{"margin":{"bottom":"var(--wp--custom--spacing--medium, 6rem)"}}}} /-->

        <!-- wp:post-featured-image {"align":"wide","style":{"spacing":{"margin":{"bottom":"var(--wp--custom--spacing--medium, 6rem)"}}}} /-->

        <!-- wp:separator {"align":"wide","className":"is-style-wide"} -->
        <hr class="wp-block-separator alignwide is-style-wide"/>
        <!-- /wp:separator --></div>
    <!-- /wp:group -->

    <!-- wp:spacer {"height":32} -->
    <div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->

    <!-- wp:post-content {"layout":{"inherit":true}} /-->

    <!-- wp:spacer {"height":32} -->
    <div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
    <!-- /wp:spacer -->

    <!-- wp:group {"layout":{"inherit":true}} -->
    <div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex"}} -->
        <div class="wp-block-group">
            <?php
            echo <<<END
                <div>
                    <p>Test paragraph</p>
                </div>
                END;

            ?>
        </div>
        <!-- /wp:group -->

        <!-- wp:spacer {"height":32} -->
        <div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
        <!-- /wp:spacer -->

        <!-- wp:separator {"className":"is-style-wide"} -->
        <hr class="wp-block-separator is-style-wide"/>
        <!-- /wp:separator -->

        <!-- wp:post-comments /--></div>
    <!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->

