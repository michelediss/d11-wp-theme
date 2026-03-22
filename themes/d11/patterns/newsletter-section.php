<?php
/**
 * Title: Newsletter Section
 * Slug: d11/newsletter-section
 * Categories: featured
 * Description: Sezione newsletter per Sputnik Press.
 */
?>
<!-- wp:group {"layout":{"type":"constrained","wideSize":"90rem"},"className":"bg-primary py-20"} -->
<div class="wp-block-group bg-primary py-20">

<!-- wp:columns {"verticalAlignment":"center","className":"px-6"} -->
<div class="wp-block-columns are-vertically-aligned-center px-6">

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%">
<!-- wp:heading {"className":"font-heading text-section-title font-bold text-light"} -->
<h2 class="wp-block-heading font-heading text-section-title font-bold text-light"><strong>Iscriviti alla newsletter</strong></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"text-base text-light/90"} -->
<p class="text-base text-light/90">Rimani aggiornato sulle novità di Sputnik Press.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%">
<!-- wp:html -->
<form action="#" method="post" class="sputnik-newsletter-form">
  <div class="flex flex-nowrap gap-2">
    <input type="email" name="email" placeholder="la-tua@email.it" required>
    <button type="submit" class="inline-flex items-center justify-center rounded-md border border-black bg-black px-6 py-3.5 text-xs font-bold uppercase tracking-brand text-light transition hover:-translate-y-px hover:brightness-95 focus:-translate-y-px focus:brightness-95 focus:outline-none">
      <?php esc_html_e( 'Iscriviti', 'd11' ); ?> &rarr;
    </button>
  </div>
</form>
<!-- /wp:html -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->
