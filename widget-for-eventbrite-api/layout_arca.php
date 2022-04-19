<?php
/**
 * Front end display of shortcode loop
 * can be overridden in child themes / themes or in wp-content/widget-for-eventbrite-api folder if you don't have a child theme and you don't want to lose changes due to themes updates
 *
 * To customise create a folder in your theme directory called widget-for-eventbrite-api and a modified version of this file or any template_parts renamed as appropriate
 *
 * The main structure is in get_template_part( 'loop__free_widget' );
 *
 * @var mixed $data Custom data for the template.
 */

if ( $data->utilities->get_element( 'widgetwrap', $data->args ) ) {
	?><div class="widget"><?php
}
// Recent posts wrapper
printf( '<div %1$s class="eaw-block wfea-cal %2$s %3$s">',
	( ! empty( $data->utilities->get_element( 'cssid', $data->args ) ) ? 'id="' . esc_attr( $data->utilities->get_element( 'cssid', $data->args ) ) . '"' : '' ),
	( ! empty( $data->utilities->get_element( 'css_class', $data->args ) ) ? '' . esc_attr( $data->utilities->get_element( 'css_class', $data->args ) ) . '' : '' ),
	( ! empty( $data->utilities->get_element( 'style', $data->args ) ) ? '' . esc_attr( $data->utilities->get_element( 'style', $data->args ) ) . '' : '' )
);
if ( false !== $data->events && $data->events->have_posts() ) {
	?>
    <div class="eaw-ulx">
    <div class="eaw-li__wrap row">
		<?php while ( $data->events->have_posts() ) {
			$data->events->the_post();
			$data->event->booknow = $data->utilities->get_booknow_link( $data->args );
			$data->event->cta     = $data->utilities->get_cta( $data->args );
			$data->template_loader->get_template_part( 'loop_widget__free' );
		}
		?>
    </div>
    </div><?php
} else {
	$data->template_loader->get_template_part( 'not_found__free' );
}
?>
    </div>
<?php
if ( $data->utilities->get_element( 'widgetwrap', $data->args ) ) {
	?></div><!-- End widget wrap --><?php
}
