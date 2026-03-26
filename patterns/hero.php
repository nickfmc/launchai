<?php
/**
 * Title: Hero — Full-width with heading and CTA
 * Slug: launchpad/hero
 * Categories: featured, text
 * Description: Full-width hero section with a heading, sub-heading, and call-to-action button.
 */
?>
<!-- wp:group {"align":"full","className":"o-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|16"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull o-section" style="padding-top:var(--wp--preset--spacing--16);padding-bottom:var(--wp--preset--spacing--16)">

    <!-- wp:group {"layout":{"type":"constrained","contentSize":"760px"}} -->
    <div class="wp-block-group">

        <!-- wp:heading {"level":1,"textAlign":"center","style":{"typography":{"fontSize":"var:preset|font-size|xxl"}}} -->
        <h1 class="wp-block-heading has-text-align-center" style="font-size:var(--wp--preset--font-size--xxl)">Your Compelling Headline Here</h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center">A brief description that supports the headline and motivates the visitor to take action. Keep it concise and benefit-focused.</p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
        <div class="wp-block-buttons">
            <!-- wp:button {"backgroundColor":"primary","textColor":"white"} -->
            <div class="wp-block-button"><a class="wp-block-button__link has-white-color has-primary-background-color has-text-color has-background wp-element-button">Get Started</a></div>
            <!-- /wp:button -->
            <!-- wp:button {"className":"is-style-outline"} -->
            <div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Learn More</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->

    </div>
    <!-- /wp:group -->

</div>
<!-- /wp:group -->
