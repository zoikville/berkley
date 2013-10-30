<?php

if(function_exists('register_sidebar')){
    register_sidebar(array(
        'name'          => 'Default',
        'before_widget' => '<section class="sidebar-widget default-%2$s %2$s widget-%1$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h1>',
        'after_title'   => '</h1>' )
    );
}



function BogoDeals_widget() {
    register_widget('BogoDeals');
}
add_action('widgets_init', 'BogoDeals_widget');

class BogoDeals extends WP_Widget {

    function BogoDeals() {
        parent::WP_Widget(false, $name = 'Bogo Deals', $widget_options = array('description' => 'Bogo Deals')); 
    }

    function widget($args, $instance) {
        global $cfs; 
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $num = apply_filters('widget_num', $instance['num']);


            echo $before_widget;
            if ($title) {
            echo $before_title;
                echo $title;
            echo $after_title; 
            }; ?>
            <div class="list">


                    <?php
                    $totalNumberOfDay = date('Y-m-d', time());
                    $totalNumberOfSeconds = strtotime($totalNumberOfDay) - 86399;
                        $footerDealsPosts = new WP_Query();
                        $footerDealsPosts -> query( array(
                            'post_type' => 'deals',
                            'showposts' => $num,
                            'meta_query' => array(
                                array(
                                    'key' => 'x_expires_date',
                                    'value' => $totalNumberOfSeconds,
                                    'compare' => '>',
                                )
                            ),
                            'order' => 'DESC', 
                            'orderby' => 'date')
                        );
                        
                        if($footerDealsPosts->have_posts()) : while($footerDealsPosts->have_posts()): $footerDealsPosts->the_post(); 
                        $post_id = get_the_ID();

                    ?>
                    
                    <article class="post clearfix">
                        <a class="img" href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail($post_id, 'in-post-3'); ?></a>
                        <h1><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h1>
                        <div><time><?php echo get_the_date(); ?></time></div>
                        <p>
                        <?php echo get_the_term_list( $post_id, 'categorys', 'Category: ', ', ', '' ); ?>
                        </p>
                    </article>
                    
                    <?php endwhile; else: ?>
                        <p>No Posts</p>
                    <?php endif; ?>
                    <?php rewind_posts(); ?>


            </div>
            <!-- END OF THE PLAYER EMBEDDING -->
            <?php 
            echo $after_widget;

    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['num'] = strip_tags($new_instance['num']);
        
        return $instance;
    }
    
    function form($instance) {
        $title = esc_attr($instance['title']);
        $num = esc_attr($instance['num']);

        ?>
        <div id="upfiles">

            <p>
            Title<br/>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            <br/><br/>
            Number of Deals<br/>
            <input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" />
            <br/><br/>
            </p>
            
        </div>
        <?php 
    }
}

function BogoCharity_widget() {
    register_widget('BogoCharity');
}
add_action('widgets_init', 'BogoCharity_widget');

class BogoCharity extends WP_Widget {

    function BogoCharity() {
        parent::WP_Widget(false, $name = 'Bogo Charity', $widget_options = array('description' => 'Bogo Charity')); 
    }

    function widget($args, $instance) {
        global $cfs; 
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $num = apply_filters('widget_num', $instance['num']);


            echo $before_widget;
            if ($title) {
            echo $before_title;
                echo $title;
            echo $after_title; 
            }; ?>
            <div class="list">


                    <?php

                        $footercharityPosts = new WP_Query();
                        $footercharityPosts -> query( array(
                            'post_type' => 'charity',
                            'showposts' => $num, 
                            'order' => 'DESC', 
                            'orderby' => 'date')
                        );
                        
                        if($footercharityPosts->have_posts()) : while($footercharityPosts->have_posts()): $footercharityPosts->the_post(); 
                        $post_id = get_the_ID();

                    ?>
                    
                    <article class="post clearfix">
                        <a class="img" href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail($post_id, 'in-post-3'); ?></a>
                        <h1><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h1>
                        <div><time><?php echo get_the_date(); ?></time></div>
                        <p>
                        <?php my_content(get_the_content(), 40); ?>
                        <span class="more"><a href="<?php echo get_permalink(); ?>">Read More ></a></span>
                        </p>
                    </article>
                    
                    <?php endwhile; else: ?>
                        <p>No Posts</p>
                    <?php endif; ?>
                    <?php rewind_posts(); ?>


            </div>
            <!-- END OF THE PLAYER EMBEDDING -->
            <?php 
            echo $after_widget;

    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['num'] = strip_tags($new_instance['num']);
        
        return $instance;
    }
    
    function form($instance) {
        $title = esc_attr($instance['title']);
        $num = esc_attr($instance['num']);

        ?>
        <div id="upfiles">

            <p>
            Title<br/>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            <br/><br/>
            Number of Charity<br/>
            <input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" />
            <br/><br/>
            </p>
            
        </div>
        <?php 
    }
}

function DealsCategories_widget() {
    register_widget('DealsCategories');
}
add_action('widgets_init', 'DealsCategories_widget');

class DealsCategories extends WP_Widget {

    function DealsCategories() {
        parent::WP_Widget(false, $name = 'Deals Categories', $widget_options = array('description' => 'Deals Categories')); 
    }

    function widget($args, $instance) {
        global $cfs; 
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);


            echo $before_widget;
            if ($title) {
            echo $before_title;
                echo $title;
            echo $after_title; 
            }; ?>


        <nav class="sidebar-menus">
            <ul>
            <?php 
            $args = array(
                'show_option_all'    => '',
                'orderby'            => 'name',
                'order'              => 'ASC',
                'style'              => 'list',
                'show_count'         => 1,
                'hide_empty'         => 1,
                'use_desc_for_title' => 0,
                'child_of'           => 0,
                'feed'               => '',
                'feed_type'          => '',
                'feed_image'         => '',
                'exclude'            => '',
                'exclude_tree'       => '',
                'include'            => '',
                'hierarchical'       => 1,
                'title_li'           => __( '' ),
                'show_option_none'   => __('No categories'),
                'number'             => null,
                'echo'               => 1,
                'depth'              => 0,
                'current_category'   => 0,
                'pad_counts'         => 0,
                'taxonomy'           => 'categorys',
                'walker'             => null
            );
            wp_list_categories($args);
            ?>
            </ul>
        </nav>


            <!-- END OF THE PLAYER EMBEDDING -->
            <?php 
            echo $after_widget;

    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        return $instance;
    }
    
    function form($instance) {
        $title = esc_attr($instance['title']);

        ?>
        <div id="upfiles">

            <p>
            Title<br/>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            <br/><br/>
            </p>
            
        </div>
        <?php 
    }
}

?>