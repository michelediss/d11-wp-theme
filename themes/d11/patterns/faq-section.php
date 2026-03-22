<?php
/**
 * Title: D11 FAQ Section
 * Slug: d11/faq-section
 * Categories: d11
 * Description: FAQ di presentazione per il tema D11.
 */
?>
<!-- wp:group {"align":"full","layout":{"type":"constrained","wideSize":"80rem"},"className":"px-6 py-20 md:px-8"} -->
<div class="wp-block-group alignfull px-6 py-20 md:px-8">
<!-- wp:columns {"className":"gap-8"} -->
<div class="wp-block-columns gap-8">
<!-- wp:column {"width":"38%"} -->
<div class="wp-block-column" style="flex-basis:38%">
<!-- wp:paragraph {"className":"section-kicker mb-4"} -->
<p class="section-kicker mb-4"><?php echo esc_html__( 'FAQ', 'd11' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"className":"max-w-xl text-section-title font-bold uppercase text-ink"} -->
<h2 class="wp-block-heading max-w-xl text-section-title font-bold uppercase text-ink"><?php echo esc_html__( 'Domande tipiche prima di adottare D11.', 'd11' ); ?></h2>
<!-- /wp:heading -->
<!-- /wp:column -->
</div>

<!-- wp:column {"width":"62%"} -->
<div class="wp-block-column" style="flex-basis:62%">
<!-- wp:group {"layout":{"type":"constrained"},"className":"space-y-4"} -->
<div class="wp-block-group space-y-4">
<!-- wp:details {"summary":"<?php echo esc_attr__( 'D11 è un tema generalista?', 'd11' ); ?>","className":"faq-panel"} -->
<details class="wp-block-details faq-panel"><summary><?php echo esc_html__( 'D11 è un tema generalista?', 'd11' ); ?></summary><!-- wp:paragraph {"className":"mt-3 text-base text-cinder/80"} -->
<p class="mt-3 text-base text-cinder/80"><?php echo esc_html__( 'No. È un tema opinionated: limita le opzioni dell’editor per aumentare la qualità media del risultato e la prevedibilità del lavoro.', 'd11' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"summary":"<?php echo esc_attr__( 'Perché usare Tailwind invece delle preset Gutenberg?', 'd11' ); ?>","className":"faq-panel"} -->
<details class="wp-block-details faq-panel"><summary><?php echo esc_html__( 'Perché usare Tailwind invece delle preset Gutenberg?', 'd11' ); ?></summary><!-- wp:paragraph {"className":"mt-3 text-base text-cinder/80"} -->
<p class="mt-3 text-base text-cinder/80"><?php echo esc_html__( 'Perché i token vivono in un’unica sorgente di verità e il front-end resta consistente tra template, pattern, blocchi custom e stili editoriali.', 'd11' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"summary":"<?php echo esc_attr__( 'L’AI può generare pagine senza rompere il tema?', 'd11' ); ?>","className":"faq-panel"} -->
<details class="wp-block-details faq-panel"><summary><?php echo esc_html__( 'L’AI può generare pagine senza rompere il tema?', 'd11' ); ?></summary><!-- wp:paragraph {"className":"mt-3 text-base text-cinder/80"} -->
<p class="mt-3 text-base text-cinder/80"><?php echo esc_html__( 'Sì, se segue whitelist blocchi, guide di composizione e pattern registrati. Il tema è stato impostato proprio per ridurre le libertà che producono markup fragile.', 'd11' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
</div>
