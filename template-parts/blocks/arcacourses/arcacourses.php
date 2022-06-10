<?php

/**
 * ArCa courses Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'arcacourse-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'arcacourse';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$course_categories = get_field( 'course_category' );
$course_max = get_field( 'course_max' );

// The post type query

if ( $course_categories ) {
	$args = array(
		'post_type'      => 'arca_course',
		'posts_per_page' => $course_max,
		'tax_query'         => [
			[
				'taxonomy'  => 'course_cat',
				'field'     => 'term_id',
				'terms'     => $course_categories,
			]
		],
	);
} else {
	$args = array(
		'post_type'      => 'arca_course',
		'posts_per_page' => $course_max,
	);
}
$query = new WP_Query( $args );

?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
	<div class="row">
		<?php while ( $query->have_posts() ) : $query->the_post();
			$course_id = get_the_ID();
			$home_excerpt = get_field( 'home_excerpt', $course_id );
			$short_excerpt = $home_excerpt ? $home_excerpt : excerpt( 17 );
		?>
		  <div class="col">
			<div class="home-courses-group">
				<h3 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php echo esc_html( $short_excerpt ); ?>
			</div>
		  </div>
	  <?php endwhile; ?>
	</div>
</div>
