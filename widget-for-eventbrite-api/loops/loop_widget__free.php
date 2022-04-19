<?php
/**
 * @var mixed $data Custom data for the template.
 */
?>

    <div class="col-12 col-md-6 col-lg-4 gy-3 gx-5 text-center <?php
	echo esc_attr( $data->utilities->get_element( 'thumb_align', $data->args ) ) . ' ';
	?>
        ">
		<?php $data->template_loader->get_template_part( 'thumb_widget__free' ); ?>
        <div class="eaw-content-wrap">
	        <?php $data->template_loader->get_template_part( 'title_widget__free' ); ?>
	        <?php $data->template_loader->get_template_part( 'date_widget__free' ); ?>
	        <?php $data->template_loader->get_template_part( 'excerpt_widget__free' ); ?>
        </div>
        <?php $data->template_loader->get_template_part( 'booknow_widget__free' ); ?>
    </div>

