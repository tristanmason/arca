<?php

/**
 * ArCa Team Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'arcateam-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'arcateam';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$team_category = get_field('team_category');
$team_max = get_field('team_max');
$team_columns_desktop = get_field('team_columns_desktop');
$team_columns_tablet = get_field('team_columns_tablet');
$team_columns_phone = get_field('team_columns_phone');
$team_show_titles = get_field('team_show_titles');
$team_show_bio = get_field('team_show_bio');

// Function that retrieves alt text for the featured image
function get_the_post_thumbnail_alt($post_id) {
    return get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
}

// The post type query

$args = array(
    'post_type'      => 'arca_team',
    'posts_per_page' => $team_max,
    'tax_query'         => [
        [
            'taxonomy'  => 'team_cat',
            'field'     => 'id',
            'terms'     => $team_category,
            'operator'  => 'OR',
        ]
    ],
);
$query = new WP_Query($args);

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="row row-cols-<?php echo $team_columns_phone; ?> row-cols-md-<?php echo $team_columns_tablet; ?> row-cols-lg-<?php echo $team_columns_desktop; ?> g-4">
      <?php while ( $query->have_posts() ) : $query->the_post();
        $team_id = get_the_ID();
        $feat_img_alt = get_the_post_thumbnail_alt($team_id);
        $feat_img_alt = $feat_img_alt ? $feat_img_alt : ( get_the_title() . " headshot" ); // if the image's alt is empty, use the name instead
        $job_title = get_field('job_title', $team_id);
        $brief_bio = get_field('brief_bio', $team_id);
        ?>
        
          <div class="col">
            <div class="card">
              <?php the_post_thumbnail('arca-team', ['class' => 'card-img-top', 'alt' => $feat_img_alt ]); ?>
              <div class="card-body">
                <h3 class="h5 card-title text-center"><?php the_title(); ?></h3>
                <?php if ( $job_title && $team_show_titles ) : ?>
                <p class="card-subtitle mb-2 text-muted text-center"><?php echo $job_title; ?></p>
                <?php endif; ?>
                <?php if ( $brief_bio && $team_show_bio ) : ?>
                <p class="card-text text-center"><?php echo $brief_bio; ?></p>
                <?php endif; ?>
              </div>
            </div>
          </div>
      <?php endwhile; ?>
    </div>
</div>
