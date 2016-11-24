<?php Namespace WordPress\Plugin\Encyclopedia;

use WP_Query;

abstract class Core {
  public static
    $base_url, # url to the plugin directory
    $plugin_file, # the main plugin file
    $plugin_folder; # the path to the folder the plugin files contains

  static function init($plugin_file){
    self::$plugin_file = $plugin_file;
    self::$plugin_folder = DirName(self::$plugin_file);
    self::loadBaseURL();

    Updates::init(self::$plugin_file, Options::get('update_username'), Options::get('update_password'));

    register_Activation_Hook(self::$plugin_file, Array(__CLASS__, 'installPlugin'));
    add_Action('loop_start', Array(__CLASS__, 'printPrefixFilter'));
    add_Action('wp_enqueue_scripts', Array(__CLASS__, 'enqueueScripts'));
    add_Action('parse_request', Array(__CLASS__, 'checkSearchRequestForTermMatch'));
  }

  static function loadBaseURL(){
    $absolute_plugin_folder = RealPath(self::$plugin_folder);

    if (StrPos($absolute_plugin_folder, ABSPATH) === 0)
      self::$base_url = get_Bloginfo('wpurl').'/'.SubStr($absolute_plugin_folder, Strlen(ABSPATH));
    else
      self::$base_url = Plugins_Url(BaseName(self::$plugin_folder));

    self::$base_url = Str_Replace("\\", '/', self::$base_url); # Windows Workaround
  }

  static function installPlugin(){
    Encyclopedia_Type::loadEncyclopediaType();
    Taxonomies::registerTaxonomies();
    Post_Type::registerPostType();
    flush_Rewrite_Rules();
  }

  static function enqueueScripts(){
    if (Options::get('embed_default_style'))
      WP_Enqueue_Style('encyclopedia', self::$base_url.'/assets/css/encyclopedia.css');
  }

  static function checkSearchRequestForTermMatch(&$request){
    # Get the current request
    $query_vars = Array_Merge(Array(
      's' => False,
      'post_type' => False
    ), $request->query_vars);

    # Check the search var and post type
    if (!is_Admin() && !empty($query_vars['s']) && $query_vars['post_type'] == Post_Type::post_type_name && Options::get('redirect_user_to_search_term')){
      # Check if there is a post with exactly this title
      $arr_encyclopedia_terms = get_Posts(Array(
        'numberposts' => 2,
        'post_type' => Post_Type::post_type_name,
        'post_title_like' => $query_vars['s'],
        'orderby' => 'title menu_order',
        'order' => 'ASC',
        'suppress_filters' => False,
        'ignore_filter_request' => True,
        'cache_results' => False
      ));

      # If there is one match only we redirect the user to this entry
      if (count($arr_encyclopedia_terms) == 1){
        WP_Redirect(get_Permalink($arr_encyclopedia_terms[0]->ID));
        exit;
      }
    }
  }

  static function isEncyclopediaArchive($query){
		if ($query->is_post_type_archive || $query->is_tax){
      $encyclopedia_taxonomies = get_Object_Taxonomies(Post_Type::post_type_name);
			if ($query->is_Post_Type_Archive(Post_Type::post_type_name) || (!empty($encyclopedia_taxonomies) && $query->is_Tax($encyclopedia_taxonomies))){
				return True;
			}
		}
		return False;
	}

  static function isEncyclopediaSearch($query){
    if ($query->is_search){
      # Check post type
			if ($query->get('post_type') == Post_Type::post_type_name) return True;

      # Check taxonomies
      $encyclopedia_taxonomies = get_Object_Taxonomies(Post_Type::post_type_name);
      if (!empty($encyclopedia_taxonomies) && $query->is_Tax($encyclopedia_taxonomies)) return True;
    }
    return False;
  }

  static function addCrossLinks($content, $post = Null){
    $post_id = isSet($post->ID) ? $post->ID : Null;
    $post_type = isSet($post->post_type) ? $post->post_type : Null;

    # Start Cross Linker
    $cross_linker = new Cross_Linker();
    $cross_linker->setSkipElements(apply_Filters('encyclopedia_cross_linking_skip_elements', Array('a', 'script', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'button', 'textarea', 'select', 'style', 'pre', 'code', 'kbd', 'tt')));
    if (!$cross_linker->loadContent($content)) return $content;

    # Link target, Complete words only, link terms once
    $link_target = Options::get('link_term_target');
    $cross_linker->setLinkTarget(isSet($link_target[$post_type]) ? $link_target[$post_type] : '_self');
    $cross_linker->linkCompleteWordsOnly(Options::get('link_complete_words_only'));
    $cross_linker->linkWordsCaseSensitive(Options::get('link_terms_case_sensitive'));
    $cross_linker->replacePhrasesOnce(Options::get('link_terms_once'));

    # Go through all encyclopedia items
    for ($current_page = $max_num_pages = 1; $current_page <= $max_num_pages; $current_page++){
      # Build the Query
      $query_args = Array(
        'post_type' => Post_Type::post_type_name,
        'post__not_in' => Options::get('link_term_in_its_content') ? Null : Array($post_id),
        'ignore_filter_request' => True,
        'posts_per_page' => apply_Filters('encyclopedia_cross_linking_posts_per_page', 100),
        'paged' => $current_page,
        'orderby' => 'post_title_length',
        'order' => 'DESC',
        'cache_results' => False
      );

      # Query the terms
      $term_query = new WP_Query($query_args);

      # Set the max_pages
      $max_num_pages = $term_query->max_num_pages;

      # Create the links
      while ($term_query->have_Posts()){
        $term = $term_query->next_Post();

        if (apply_Filters('encyclopedia_link_term_in_content', True, $term, $post, $cross_linker)){
          $cross_linker->linkPhrase($term->post_title, self::getLinkTitle($term), get_Permalink($term->ID));
        }
      }
    }

    # Overwrite the content with the parsers document which contains the links to each term
    $content = $cross_linker->getParserDocument();

    return $content;
	}

  static function getLinkTitle($term){
    $title = $more = $length = False;

    if (empty($term->post_excerpt)){
      $more = apply_Filters('encyclopedia_link_title_more', '&hellip;');
      $more = HTML_Entity_Decode($more, ENT_QUOTES, 'UTF-8');
      $length = apply_Filters('encyclopedia_link_title_length', Options::get('cross_link_title_length'));
      $title = strip_Shortcodes($term->post_content);
      $title = WP_Strip_All_Tags($title);
      $title = HTML_Entity_Decode($title, ENT_QUOTES, 'UTF-8');
      $title = WP_Trim_Words($title, $length, $more);
    }
    else {
      $title = WP_Strip_All_Tags($term->post_excerpt, True);
      $title = HTML_Entity_Decode($title, ENT_QUOTES, 'UTF-8');
    }

    $title = apply_Filters('encyclopedia_term_link_title', $title, $term, $more, $length);

    return $title;
  }

  static function printPrefixFilter($query){
    static $loop_already_started;
    if ($loop_already_started) return;

    # If this is feed we bail out
    if (is_Feed()) return;

    # If the current query is not a post query we bail out
    if (!(getType($query) == 'object' && get_Class($query) == 'WP_Query')) return;

    global $wp_current_filter;
    if (in_Array('wp_head', $wp_current_filter)) return;

    # Conditions
    if ($query->is_Main_Query() && !$query->get('suppress_filters')){
      $is_archive_filter = self::isEncyclopediaArchive($query) && Options::get('prefix_filter_for_archives');
      $is_singular_filter = $query->is_Singular(Post_Type::post_type_name) && Options::get('prefix_filter_for_singulars');

      # Get the Filter depth
      $filter_depth = False;
      if ($is_archive_filter) $filter_depth = Options::get('prefix_filter_archive_depth');
      elseif ($is_singular_filter) $filter_depth = Options::get('prefix_filter_singular_depth');

      if ($is_archive_filter || $is_singular_filter){
        Prefix_Filter::printFilter($filter_depth);
        $loop_already_started = True;
      }
    }
  }

  static function getTagRelatedTerms($arguments = Null){
    global $wpdb, $post;

    $arguments = is_Array($arguments) ? $arguments : Array();

    # Load default arguments
    $arguments = (Object) Array_Merge(Array(
      'term_id' => isSet($post->ID) ? $post->ID : Null,
      'number' => 10,
      'taxonomy' => 'encyclopedia-tag'
    ), $arguments);

    # apply filter
    $arguments = apply_Filters('encyclopedia_tag_related_terms_arguments', $arguments);

    # if there is no term set we bail out
    if (empty($arguments->term_id)) return False;

    # Get the Tags
    $arr_tags = WP_Get_Post_Terms($arguments->term_id, $arguments->taxonomy);
    if (empty($arr_tags)) return False;

    # Get term IDs
    $arr_term_ids = Array();
    foreach ($arr_tags as $taxonomy) $arr_term_ids[] = $taxonomy->term_taxonomy_id;
    $str_tag_list = implode(',', $arr_term_ids);

    # The Query to get the related posts
    $stmt = " SELECT posts.*,
                     COUNT(term_relationships.object_id) AS common_tag_count
              FROM   {$wpdb->term_relationships} AS term_relationships,
                     {$wpdb->posts} AS posts
              WHERE  term_relationships.object_id = posts.id
              AND    term_relationships.term_taxonomy_id IN({$str_tag_list})
              AND    posts.id != {$arguments->term_id}
              AND    posts.post_status = 'publish'
              GROUP  BY term_relationships.object_id
              ORDER  BY common_tag_count DESC,
                     posts.post_date_gmt DESC
              LIMIT  0, {$arguments->number}";

    # Put it in a WP_Query
    $query = new WP_Query();
    $query->posts = $wpdb->get_Results($stmt);
    $query->post_count = count($query->posts);
    $query->rewind_Posts();

    # apply a filter to the query object
    do_Action('encyclopedia_tag_related_terms_query_object', $query, $arguments);

    # return
    return ($query->post_count > 0) ? $query : False;
  }

}
