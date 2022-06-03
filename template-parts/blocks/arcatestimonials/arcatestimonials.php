<?php

/**
 * ArCa Testimonials Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'arcatestimonial-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'arcatestimonial';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$testimonial_categories = get_field( 'testimonial_category' );
$testimonial_max = get_field( 'testimonial_max' );
$testimonial_columns_desktop = get_field( 'testimonial_columns_desktop' );
$testimonial_columns_tablet = get_field( 'testimonial_columns_tablet' );
$testimonial_columns_phone = get_field( 'testimonial_columns_phone' );
$testimonial_max_width = get_field( 'testimonial_max_width' );

// The post type query

if ( $testimonial_categories ) {
	$args = array(
		'post_type'      => 'arca_testimonial',
		'posts_per_page' => $testimonial_max,
		'tax_query'         => [
			[
				'taxonomy'  => 'testimonial_cat',
				'field'     => 'term_id',
				'terms'     => $testimonial_categories,
			]
		],
	);
} else {
	$args = array(
		'post_type'      => 'arca_testimonial',
		'posts_per_page' => $testimonial_max,
	);
}
$query = new WP_Query( $args );

?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
	<div class="row row-cols-<?php echo $testimonial_columns_phone; ?> row-cols-sm-<?php echo $testimonial_columns_tablet; ?> row-cols-lg-<?php echo $testimonial_columns_desktop; ?> g-4 g-lg-5 justify-content-center">
		<?php while ( $query->have_posts() ) : $query->the_post();
			$testimonial_id = get_the_ID();
			$feat_img_alt = get_the_post_thumbnail_alt( $testimonial_id );
			$feat_img_alt = $feat_img_alt ? $feat_img_alt : ( get_the_title() . " headshot" ); // if the image's alt is empty, use the name instead
			$testimonial_text = get_field( 'testimonial', $testimonial_id );
		?>
		
		  <div class="col">
			<div class="card pt-2 px-1 px-sm-0 px-lg-1">
			  <div class="card-body text-center">
				<?php the_post_thumbnail( 'medium', ['class' => 'testimonial-headshot', 'alt' => $feat_img_alt ] ); ?>
				<p class="card-text">&#8220;<?php echo esc_html( $testimonial_text ); ?>&#8221;</p>
				<p class="quote-attribution">&ndash;<?php the_title(); ?></p>
			  </div>
			</div>
		  </div>
	  <?php endwhile; ?>
	</div>
</div>
<?php if ( $testimonial_max_width ) : ?>
	<style>
		@media (min-width: <?php echo $testimonial_max_width . "px"; ?>) {
			.arcatestimonial {
				max-width: <?php echo $testimonial_max_width . "px"; ?>;
				margin: 0 auto;
			}
		}
	</style>
<?php endif; ?>
