<?php Namespace WordPress\Plugin\Encyclopedia;

abstract class AJAX_Requests {

  static function init(){
    add_Action('wp_ajax_encyclopedia_search', Array(__CLASS__, 'Search_Autocomplete'));
    add_Action('wp_ajax_nopriv_encyclopedia_search', Array(__CLASS__, 'Search_Autocomplete'));
  }

  static function Search_Autocomplete(){
    $search_term = trim($_REQUEST['term']);

    $arr_encyclopedia_terms = get_Posts(Array(
      'numberposts' => 25,
      'post_type' => Post_Type::post_type_name,
      'post_title_like' => sprintf('%%%s%%', $search_term),
      'orderby' => 'title menu_order',
      'order' => 'ASC',
      'suppress_filters' => False,
      'ignore_filter_request' => True
    ));

    foreach ($arr_encyclopedia_terms as &$term)
      $term = $term->post_title;

    echo JSON_Encode($arr_encyclopedia_terms); exit;
  }

}

AJAX_Requests::init();
