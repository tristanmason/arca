<?php
/**
 * ArCa Logo Carousel Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'arcaLogoCarousel-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'arcaLogoCarousel';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

$images = get_field( 'logo_images' );
$num_images = count( $images );
if ( $images ) : ?>
	<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
		<div id="logosWrapper">
			<div class="logosInner">
			<?php foreach ( $images as $image ): ?>
				<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['sizes']['medium-width']?>" height="<?php echo $image['sizes']['medium-height']?>" class="no-lazy" />
			<?php endforeach; ?>
			<?php foreach ( $images as $image ): ?>
				<img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['sizes']['medium-width']?>" height="<?php echo $image['sizes']['medium-height']?>" class="no-lazy" />
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	<style type="text/css">
		#logosWrapper {
			height: 150px;
			position:relative; 
			overflow:hidden;
		}
		.logosInner {
			min-height: 150px;
			background: #fff;
			position:absolute; 
			top:0px; 
			left:0px;
			white-space: nowrap;
			animation: logosAnimate <?php echo ( $num_images * 6.5 ); ?>s linear infinite;
		}
		.logosInner img {    
			margin: 0 1em;
			max-width: 200px;
			max-height: 200px;
		}
		@keyframes logosAnimate {
			0% {
				transform: translate(0, 0);
			}
			100% {
				transform: translate(-50%, 0);
			}
		}
	</style>
<?php endif; ?>
