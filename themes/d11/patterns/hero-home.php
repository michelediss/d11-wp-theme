<?php
/**
 * Title: Hero Home
 * Slug: d11/hero-home
 * Categories: hero
 * Description: Hero section per la home page di Sputnik Press.
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-ink-bg.png' ) ); ?>","dimRatio":0,"minHeight":100,"minHeightUnit":"vh","contentPosition":"bottom left","isDark":true,"className":"sputnik-hero px-6 pb-20"} -->
<div class="wp-block-cover is-dark has-custom-content-position is-position-bottom-left sputnik-hero px-6 pb-20" style="min-height:100vh">
<span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-ink-bg.png' ) ); ?>" data-object-fit="cover" />
<div class="wp-block-cover__inner-container">

<!-- wp:heading {"level":1,"className":"max-w-5xl font-heading text-hero font-bold uppercase text-light"} -->
<h1 class="wp-block-heading max-w-5xl font-heading text-hero font-bold uppercase text-light"><strong>DOOMED<br><span class="text-primary">UNO</span></strong></h1>
<!-- /wp:heading -->

<!-- wp:buttons {"className":"mt-6"} -->
<div class="wp-block-buttons mt-6">
<!-- wp:button {"className":"site-button"} -->
<div class="wp-block-button site-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( get_permalink( 42 ) ); ?>"><?php esc_html_e( 'Scopri il libro', 'd11' ); ?> →</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
</div>
<!-- /wp:cover -->
