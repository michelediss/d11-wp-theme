<?php
/**
 * Title: D11 CTA Band
 * Slug: d11/cta-band
 * Categories: d11
 * Description: Banda finale con call to action per il sito di presentazione D11.
 */
?>
<!-- wp:group {"align":"full","layout":{"type":"constrained","wideSize":"80rem"},"className":"px-6 pb-24 pt-6 md:px-8"} -->
<div class="wp-block-group alignfull px-6 pb-24 pt-6 md:px-8">
<!-- wp:group {"layout":{"type":"constrained","contentSize":"1100px"},"className":"cta-band overflow-hidden rounded-[2rem] px-7 py-10 text-white shadow-panel md:px-10 md:py-14"} -->
<div class="wp-block-group cta-band overflow-hidden rounded-[2rem] px-7 py-10 text-white shadow-panel md:px-10 md:py-14">
<!-- wp:columns {"verticalAlignment":"center","className":"gap-8"} -->
<div class="wp-block-columns are-vertically-aligned-center gap-8">
<!-- wp:column {"width":"65%"} -->
<div class="wp-block-column" style="flex-basis:65%">
<!-- wp:paragraph {"className":"brand-kicker mb-4 text-white/80"} -->
<p class="brand-kicker mb-4 text-white/80"><?php echo esc_html__( 'Call to action', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"className":"max-w-3xl text-display font-bold uppercase text-white"} -->
<h2 class="wp-block-heading max-w-3xl text-display font-bold uppercase text-white"><?php echo esc_html__( 'Serve un tema WordPress che faccia meno caos e più sistema?', 'd11' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"mt-5 max-w-2xl text-lead text-white/90"} -->
<p class="mt-5 max-w-2xl text-lead text-white/90"><?php echo esc_html__( 'D11 nasce per impostare limiti utili: design tokens chiari, blocchi governati, pattern riusabili e una homepage che può essere adattata senza ripartire ogni volta da zero.', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:column -->
</div>

<!-- wp:column {"width":"35%"} -->
<div class="wp-block-column" style="flex-basis:35%">
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"site-button site-button--dark"} -->
<div class="wp-block-button site-button site-button--dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/#system')); ?>"><?php echo esc_html__( 'Rivedi il sistema', 'd11' ); ?></a></div>
<!-- /wp:button -->
<!-- /wp:buttons -->
</div>

<!-- wp:paragraph {"className":"mt-4 text-sm text-white/70"} -->
<p class="mt-4 text-sm text-white/70"><?php echo esc_html__( 'Usa questa homepage come base del sito di presentazione del tema e poi rifinisci menu, logo e contenuti nel Site Editor.', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
