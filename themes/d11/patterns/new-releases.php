<?php
/**
 * Title: New Releases
 * Slug: d11/new-releases
 * Categories: featured
 * Description: Sezione ultime pubblicazioni per Sputnik Press.
 */
?>
<!-- wp:group {"layout":{"type":"constrained","wideSize":"90rem"},"className":"bg-light py-24"} -->
<div class="wp-block-group bg-light py-24" id="catalogo">

<!-- wp:columns {"verticalAlignment":"bottom","className":"mb-16 px-6"} -->
<div class="wp-block-columns are-vertically-aligned-bottom mb-16 px-6">

<!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%">
<!-- wp:heading {"className":"font-heading text-display font-bold uppercase text-black"} -->
<h2 class="wp-block-heading font-heading text-display font-bold uppercase text-black"><strong>Ultime<br><span class="text-primary">Pubblicazioni</span></strong></h2>
<!-- /wp:heading -->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%">
<!-- wp:group {"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"text-xs font-semibold uppercase tracking-brand text-black"} -->
<p class="text-xs font-semibold uppercase tracking-brand text-black"><a class="text-black no-underline hover:text-primary focus:text-primary" href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ); ?>"><?php esc_html_e( 'Catalogo completo', 'd11' ); ?> ↗</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

<!-- wp:query {"queryId":1,"query":{"perPage":6,"postType":"product","order":"desc","orderBy":"date"},"layout":{"type":"grid","columnCount":6},"className":"px-6"} -->
<div class="wp-block-query px-6">
<!-- wp:post-template -->
<!-- wp:group {"layout":{"type":"constrained"},"className":"gap-1"} -->
<div class="wp-block-group gap-1">
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"2/3","width":"100%","className":"overflow-hidden rounded-lg"} /-->
<!-- wp:post-title {"isLink":true,"level":4,"className":"text-sm font-semibold leading-snug text-black"} /-->
<!-- wp:post-author {"className":"text-xs text-black/70"} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->

</div>
<!-- /wp:group -->
