<?php
/**
 * ArCa Inner Container Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'innercontainer-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'innercontainer';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}

// Template for default inner blocks
$template = array(
	array(
		'core/paragraph',
		array(
			'content' => 'Any blocks (like this one) inside the Inner Container will be limited to the maximum width you set. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
		),
	),
);

// Load values and assign defaults.
$container_max_width = get_field( 'container_max_width' );
$container_width_unit = get_field( 'container_width_unit' );
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>" style="max-width:<?php echo esc_attr( $container_max_width ) . esc_attr( $container_width_unit ); ?>;margin:0 auto;">
	<?php echo '<InnerBlocks template="' . esc_attr( wp_json_encode( $template ) ) . '" />'; ?>
</div>