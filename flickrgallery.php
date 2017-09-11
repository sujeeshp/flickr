<?php
/*
plugin Name:flickr gallery Plugin
Plugin URI:http://www.example.com
Description:A first Plugin alternative to the boring "Hello world" examples
Author:peter
Version:1.0
Author URI:http://www.example.com
*/

class RM_Flickr extends WP_Widget
{

    function RM_Flickr()
    {
        $widget_ops = array( 'classname' => 'flickr_widget', 'description' => 'Show your favorite Flickr photos!' );
        $this->WP_Widget( 'flickr_widget', 'Flickr Posts', $widget_ops);
    }

    function form($instance)
    {
      $instance = wp_parse_args( (array) $instance, array('title' => 'Flickr Photos', 'number' => 5, 'flickr_id' => '') );

      $title = esc_attr($instance['title']);
      $flickr_id = $instance['flickr_id'];
      $number = absint($instance['number']);
    }

    function update($new_instance, $old_instance)
    {
        $instance=$old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['flickr_id']=$new_instance['flickr_id'];
        $instance['number']=$new_instance['number'];
        return $instance;
    }

    function widget($args, $instance)
    {
      extract($args);

      $title = apply_filters('widget_title', $instance['title']);

      if ( empty($title) ) $title = false;
      $flickr_id = $instance['flickr_id'];
      $number = absint( $instance['number'] );
    }

}


    add_action( 'widgets_init', 'rm_load_widgets' );
    function rm_load_widgets()
    {
    register_widget('RM_Flickr');
    }
?>
