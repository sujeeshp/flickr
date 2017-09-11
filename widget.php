<?php
class RM_Flickr extends WP_Widget {

    function RM_Flickr() {
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
function rm_load_widgets() {
    register_widget('RM_Flickr');
}
?>
<p>
               <label for="<?php echo $this->get_field_id('title'); ?>">
                  Title:
               </label>
                   <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
           </p>



           <p>
               <label for="<?php echo $this->get_field_id('flickr_id'); ?>">
                  Flickr username:
               </label>
                   <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" />

           </p>

           <p>

           <p>
               <label for="<?php echo $this->get_field_id('number'); ?>">
                  Number of Photos:
               </label>
                   <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
           </p>


   <?php
   if (!empty($flickr_id)) {

  echo $before_widget;

  if($title){
      echo $before_title;
      echo $title;
      echo $after_title;
  }

  $person = $f->people_findByUsername($flickr_id);
  $photos_url = $f->urls_getUserPhotos($person['id']);
  $photos = $f->people_getPublicPhotos($person['id'], NULL, NULL, $number);


  foreach ((array)$photos['photos']['photo'] as $photo) {
      echo "<br />\n";
      echo "<a href=$photos_url$photo[id]>";
      echo "<img border='0' alt='$photo[title]' ".
      "src=" . $f->buildPhotoURL($photo, "Small") . ">";
      echo "</a>";

      echo "<br />\n";
  }
  echo $after_widget;
}
?>
