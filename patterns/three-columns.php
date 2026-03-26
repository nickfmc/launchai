<?php
/**
 * Title: Three Columns — Icon, Heading, Text
 * Slug: launchpad/three-columns
 * Categories: columns, text
 * Description: Three-column layout with heading and body text per column. Good for features or services.
 */
?>
<!-- wp:group {"align":"full","className":"o-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|16"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull o-section" style="padding-top:var(--wp--preset--spacing--16);padding-bottom:var(--wp--preset--spacing--16)">

    <!-- wp:columns {"isStackedOnMobile":true} -->
    <div class="wp-block-columns">

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:heading {"level":3} -->
            <h3 class="wp-block-heading">Feature One</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph -->
            <p>Describe the first feature or service here. Focus on the benefit to the reader, not the technical details.</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:heading {"level":3} -->
            <h3 class="wp-block-heading">Feature Two</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph -->
            <p>Describe the second feature or service here. Focus on the benefit to the reader, not the technical details.</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:heading {"level":3} -->
            <h3 class="wp-block-heading">Feature Three</h3>
            <!-- /wp:heading -->
            <!-- wp:paragraph -->
            <p>Describe the third feature or service here. Focus on the benefit to the reader, not the technical details.</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</div>
<!-- /wp:group -->
