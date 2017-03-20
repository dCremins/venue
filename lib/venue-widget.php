<?php

namespace Venue\Widget;

class VenueWidget extends \WP_Widget
{
// constructor
    public function __construct()
    {
        $widget_details = array(
            'classname' => 'VenueWidget',
            'description' => 'Venue and Hotel Information Widget'
        );

        parent::__construct('VenueWidget', 'Venue and Hotels Widget', $widget_details);
    }

// widget form creation
    public function form($instance)
    {
// Backend Form
        $title = (isset($instance['title'])) ? $instance['title'] : 'New Title';
        $link = (isset($instance['link'])) ? $instance['link'] : ''; ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link to Venue Page:'); ?></label>
          <input class="widefat" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
        </p>
    <?php
    } //End Form

// widget update
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['link'] = (!empty($new_instance['link'])) ? strip_tags($new_instance['link']) : '';
        return $instance;
    } //End Update

// widget display
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $link = $instance['link'];
// before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {
            if (!empty($link)) {
                echo '<a href="' . $link . '">';
            }
            if (is_front_page()) {
                echo '<h4 class="homepage">' . $title . '</h4>';
            } else {
                echo '<h5>' . $title . '</h5>';
            }
            if (!empty($link)) {
                echo '</a>';
            }
        }

// display venue, hotel, and info cards
        if (have_rows('hotels', 'option')) :
            echo '<div class="flex">';
            $image = get_field('image', 'option');
            echo '<div class="card accent background">';
            echo '<a class="brand color inverse" href="' . $link . '">';
            if (!empty($image)) :
                echo '<div class="card-image">';
                echo '<img class="card-img-top" src="'
                . $image['url']
                . '" alt="'
                . ' ' . get_field('venue_name', 'option')
                . '">';
                echo '</div>';
            endif;
            echo '<div class="card-block brand background">
            <h5 class="card-title brand color inverse">';
            the_field('venue_name', 'option');
            echo '</h5></div>
            </a>
            </div>';
            $count = 1;

            while (have_rows('hotels', 'option')) :
                the_row();
                if ($count >= 3) {
                    break;
                }
                if (get_row_layout() == 'hotel') :
                    $count += 1;
                    $hotel_image = get_sub_field('image');
                    echo '<div class="card accent background">';
                    echo '<a class="brand color inverse" href="' . $link . '">';
                    if (!empty($hotel_image)) :
                        echo '<div class="card-image">';
                        echo '<img class="card-img-top" src="'
                        . $hotel_image['url']
                        . '" alt="'
                        . ' ' . get_sub_field('name', 'option')
                        . '">';
                        echo '</div>';
                    endif;
                    echo '<div class="card-block brand background">
                    <h5 class="card-title brand color inverse">';
                    the_sub_field('name', 'option');
                    echo '</h5></div>
                    </a>
                    </div>';
                elseif (get_row_layout() == 'info') :
                    $count += 1;
                    $info_image = get_sub_field('image');
                    echo '<div class="card accent background">';
                    echo '<a class="brand color inverse" href="' . $link . '">';
                    if (!empty($info_image)) :
                        echo '<div class="card-image">';
                        echo '<img class="card-img-top" src="'
                        . $info_image['url']
                        . '" alt="'
                        . ' ' . get_sub_field('title', 'option')
                        . '">';
                        echo '</div>';
                    endif;
                    echo '<div class="card-block brand background">
                    <h5 class="card-title brand color inverse">';
                    the_sub_field('title', 'option');
                    echo '</h5></div>
                    </a>
                    </div>';
                endif;
            endwhile;
            echo '</div>';
        else :
// no layouts found
        endif;
        echo $args['after_widget'];
    } //widget end
} //class end

// register widget
add_action('widgets_init', function () {
    register_widget('Venue\Widget\VenueWidget');
});
