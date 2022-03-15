<?php

/**
 * ArCa Flexi-Spacer Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'flexispacer-' . $block['id'];
if ( !empty($block['anchor']) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'flexispacer';
if ( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}

// Load values and assign defaults.
$flexi_min = get_field('flexi_min');
$flexi_vw = get_field('flexi_vw');
$min_height_tablets = get_field('min_height_tablets');
$min_height_desktops = get_field('min_height_desktops');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>"></div>
<style>
	#<?php echo esc_attr( $id ); ?>{
		height:calc(<?php echo $flexi_min . 'px + ' . $flexi_vw . 'vw'?>);
	}
	<?php if ( $min_height_tablets ) : ?>
		@media (min-width:600px) {
		#<?php echo esc_attr( $id ); ?>{
			height:calc(<?php echo $min_height_tablets . 'px + ' . $flexi_vw . 'vw'?>);
		}
	}<?php endif; ?>
	<?php if ($min_height_desktops) : ?>@media (min-width:1200px) {
		#<?php echo esc_attr( $id ); ?>{
			height:calc(<?php echo $min_height_desktops . 'px + ' . $flexi_vw . 'vw'?>);
		}
	}<?php endif; ?>
</style>
