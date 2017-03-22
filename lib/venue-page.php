<?php
 /*
 Template Name: Venue and Hotels Template
 */
?>

<div class="row">
  <div class="col">
    <h1><?php the_field('venue_name', 'option') ?></h1>
    <p><?php the_field('venue_description', 'option') ?></p>
  </div>
  <div class="col">
    <?php
    $location = get_field('venue_location', 'option');
    if (!empty($location)) : ?>
      <div alt="Embeded Google Map of the Venue Location" class="acf-map">
        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
        <?php
    endif;
    if (have_rows('hotels', 'option')) :
        while (have_rows('hotels', 'option')) :
            the_row();
            if (get_row_layout() == 'hotel') :
                $location = get_sub_field('location');?>
          <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
              <h4><?php the_sub_field('title'); ?></h4>
              <p class="address"><?php echo $location['address']; ?></p>
              <p><?php the_sub_field('description'); ?></p>
          </div>
            <?php
            endif;
        endwhile;
    endif; ?>
      </div>
  </div>
</div>

<?php if (have_rows('hotels', 'option')) :
// loop through the rows of data
    while (have_rows('hotels', 'option')) :
        the_row();
        if (get_row_layout() == 'hotel') : ?>
        <div class="row">
          <div class="col">
            <?php
            $image = get_sub_field('image');
            if (!empty($image)) : ?>
                <img class="hotel-image" src="<?php echo $image['url']; ?>" alt="<?php the_sub_field('name', 'option'); ?>" />
            <?php
            endif; ?>
          </div>
          <div class="col stretch">
            <h2><?php the_sub_field('name', 'option') ?></h2>
            <?php the_sub_field('description', 'option') ?>
          </div>
        </div>
        <?php
        elseif (get_row_layout() == 'info') : ?>
        <div class="row">
          <div class="col">
            <?php
            $image = get_sub_field('image');
            if (!empty($image)) : ?>
                <img class="hotel-image" src="<?php echo $image['url']; ?>" alt="<?php the_sub_field('title', 'option'); ?>" />
            <?php
            endif; ?>
          </div>
          <div class="col stretch">
            <h2><?php the_sub_field('title', 'option') ?></h2>
            <?php the_sub_field('information', 'option') ?>
          </div>
        </div>
        <?php
        endif;
    endwhile;
else :
    // no layouts found
endif;
?>
