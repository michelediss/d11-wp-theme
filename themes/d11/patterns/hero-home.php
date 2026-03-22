<?php
/**
 * Title: D11 Hero Home
 * Slug: d11/hero-home
 * Categories: d11
 * Description: Hero di presentazione per il tema WordPress D11.
 */
?>
<!-- wp:group {"align":"full","layout":{"type":"constrained","wideSize":"80rem"},"className":"relative overflow-hidden px-6 pb-20 pt-12 md:px-8 md:pb-24 md:pt-20"} -->
<div class="wp-block-group alignfull relative overflow-hidden px-6 pb-20 pt-12 md:px-8 md:pb-24 md:pt-20">
<!-- wp:group {"layout":{"type":"constrained","contentSize":"1100px"},"className":"showcase-shell relative overflow-hidden rounded-[2rem] border border-line/80 px-6 py-10 shadow-panel md:px-10 md:py-14"} -->
<div class="wp-block-group showcase-shell relative overflow-hidden rounded-[2rem] border border-line/80 px-6 py-10 shadow-panel md:px-10 md:py-14">
<!-- wp:group {"layout":{"type":"default"},"className":"hero-orbit absolute -right-12 top-12 h-36 w-36 bg-sun/30"} -->
<div class="wp-block-group hero-orbit absolute -right-12 top-12 h-36 w-36 bg-sun/30"></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"default"},"className":"hero-orbit absolute bottom-[-3rem] left-[-2rem] h-28 w-28 bg-primary/20"} -->
<div class="wp-block-group hero-orbit absolute bottom-[-3rem] left-[-2rem] h-28 w-28 bg-primary/20"></div>
<!-- /wp:group -->

<!-- wp:columns {"verticalAlignment":"center","className":"relative z-10 gap-8"} -->
<div class="wp-block-columns are-vertically-aligned-center relative z-10 gap-8">
<!-- wp:column {"width":"62%"} -->
<div class="wp-block-column" style="flex-basis:62%">
<!-- wp:paragraph {"className":"brand-kicker mb-5"} -->
<p class="brand-kicker mb-5"><?php echo esc_html__( 'Block-first. Tailwind-native. AI-ready.', 'd11' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"max-w-4xl text-hero font-bold uppercase tracking-hero text-ink"} -->
<h1 class="wp-block-heading max-w-4xl text-hero font-bold uppercase tracking-hero text-ink"><?php echo esc_html__( 'D11 trasforma WordPress in un sistema editoriale nitido, veloce e controllabile.', 'd11' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"mt-6 max-w-2xl text-lead text-cinder/80"} -->
<p class="mt-6 max-w-2xl text-lead text-cinder/80"><?php echo esc_html__( 'Un tema block-first pensato per team che vogliono comporre pagine in Gutenberg senza perdere direzione visiva, qualità front-end e coerenza operativa.', 'd11' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"mt-8"} -->
<div class="wp-block-buttons mt-8">
<!-- wp:button {"className":"site-button"} -->
<div class="wp-block-button site-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/#system')); ?>"><?php echo esc_html__( 'Esplora il sistema', 'd11' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"site-button site-button--ghost"} -->
<div class="wp-block-button site-button site-button--ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/#preview')); ?>"><?php echo esc_html__( 'Guarda la homepage', 'd11' ); ?></a></div>
<!-- /wp:button -->
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
</div>

<!-- wp:column {"width":"38%"} -->
<div class="wp-block-column" style="flex-basis:38%">
<!-- wp:group {"layout":{"type":"constrained"},"className":"space-y-4"} -->
<div class="wp-block-group space-y-4">
<!-- wp:group {"layout":{"type":"constrained"},"className":"rounded-card border border-line/80 bg-white/80 p-6 shadow-card backdrop-blur-sm"} -->
<div class="wp-block-group rounded-card border border-line/80 bg-white/80 p-6 shadow-card backdrop-blur-sm">
<!-- wp:paragraph {"className":"section-kicker mb-3"} -->
<p class="section-kicker mb-3"><?php echo esc_html__( 'Design system', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"text-metric font-heading font-bold uppercase tracking-hero text-ink"} -->
<p class="text-metric font-heading font-bold uppercase tracking-hero text-ink">01</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"mt-2 text-base text-cinder/80"} -->
<p class="mt-2 text-base text-cinder/80"><?php echo esc_html__( 'Palette calda, tipografia netta e componenti composti per pattern, non per override occasionali.', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:group -->
</div>

<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"className":"gap-3 pt-4"} -->
<div class="wp-block-group gap-3 pt-4">
<!-- wp:paragraph {"className":"metric-chip"} -->
<p class="metric-chip"><?php echo esc_html__( 'Whitelist blocchi', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"metric-chip"} -->
<p class="metric-chip"><?php echo esc_html__( 'Pattern PHP traducibili', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"metric-chip"} -->
<p class="metric-chip"><?php echo esc_html__( 'Vite + Tailwind', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
