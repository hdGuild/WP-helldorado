<?php Namespace WordPress\Plugin\Encyclopedia;

abstract class ShortCode_Filter {
  private static
    $shortcode_callbacks;

  static function init(){
    #add_Action('template_redirect', Array(__CLASS__, 'hijackAllShortcodes'), 100);
  }

  static function hijackAllShortcodes(){
    global $shortcode_tags;
    static $done = false;

    if (!$done){
      self::$shortcode_callbacks = $shortcode_tags;
      foreach ($shortcode_tags as $tag => &$callback){
        $callback = Array(__CLASS__, 'renderShortcode');
      }
      unset($callback);
      $done = True;
    }
  }

  static function renderShortcode($atts, $content, $tag){
    $original_callback = isSet(self::$shortcode_callbacks[$tag]) ? self::$shortcode_callbacks[$tag] : False;

    if (is_Callable($original_callback)){
      $output = call_User_Func($original_callback, $atts, $content, $tag);
      $output = apply_Filters('shortcode_output', $output, $atts, $content, $tag);
      $output = apply_Filters("shortcode_output_{$tag}", $output, $atts, $content, $tag);
    }

    return $output;
  }

}

Shortcode_Filter::init();
