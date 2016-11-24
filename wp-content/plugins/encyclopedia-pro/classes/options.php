<?php Namespace WordPress\Plugin\Encyclopedia;

abstract class Options {
  const
    page_slug = 'encyclopedia-options',
    options_key = 'wp_plugin_encyclopedia';

  private static
    $arr_option_box = Array();

  static function init(){
    # Option boxes
    self::$arr_option_box = Array( 'main' => Array(), 'side' => Array() );
    add_Action('admin_menu', Array(__CLASS__, 'addOptionsPage'));
  }

  static function addOptionsPage(){
    $handle = add_Options_Page(
      sprintf(I18n::t('%s Settings'), Encyclopedia_Type::$type->label),
      Encyclopedia_Type::$type->label,
      'manage_options',
      self::page_slug,
      Array(__CLASS__, 'printOptionsPage')
    );

    # Add JavaScript to this handle
    add_Action('load-' . $handle, Array(__CLASS__, 'loadOptionsPage'));

    # Add option boxes
    self::addOptionBox(__('General'), Core::$plugin_folder.'/options-page/general.php');
    self::addOptionBox(I18n::t('Features'), Core::$plugin_folder.'/options-page/features.php');
    self::addOptionBox(I18n::t('Taxonomies'), Core::$plugin_folder.'/options-page/taxonomies.php');
    self::addOptionBox(I18n::t('Archives'), Core::$plugin_folder.'/options-page/archive-page.php');
    self::addOptionBox(I18n::t('Search'), Core::$plugin_folder.'/options-page/search.php');
    self::addOptionBox(I18n::t('Single View'), Core::$plugin_folder.'/options-page/single-page.php');
    self::addOptionBox(I18n::t('Cross Linking'), Core::$plugin_folder.'/options-page/cross-linking.php');
    self::addOptionBox(I18n::t('User Permissions'), Core::$plugin_folder.'/options-page/permissions.php', 'main');
    self::addOptionBox(I18n::t('Archive URLs'), Core::$plugin_folder.'/options-page/archive-link.php', 'side');
    self::addOptionBox(I18n::t('License'), Core::$plugin_folder.'/options-page/license.php', 'side');
  }

  static function getOptionsPageUrl($parameters = Array()){
    $url = add_Query_Arg(Array('page' => self::page_slug), Admin_Url('options-general.php'));
    if (is_Array($parameters) && !empty($parameters)) $url = add_Query_Arg($parameters, $url);
    return $url;
  }

  static function loadOptionsPage(){
    # If the Request was redirected from a "Save Options"-Post
    if (isSet($_REQUEST['options_saved'])) flush_Rewrite_Rules();

    # If this is a Post request to save the options
    if (self::saveOptions()) WP_Redirect(self::getOptionsPageUrl(Array('options_saved' => 'true')));

    #WP_Enqueue_Script('dashboard');
    WP_Enqueue_Style('dashboard');

    #WP_Enqueue_Script('options-page', Core::$base_url . '/options-page/options-page.js', Array('jquery'), Null, True);
    #Version_Compare(get_Bloginfo('version'), '4.4', '<') && WP_Enqueue_Style('options-page-campat', Core::$base_url . '/options-page/options-page-compat.css');
    WP_Enqueue_Style('options-page', Core::$base_url . '/options-page/options-page.css');

    # Remove incompatible JS Libs
    WP_Dequeue_Script('post');
  }

  static function printOptionsPage(){
    include Core::$plugin_folder.'/options-page/options-page.php';
  }

  static function addOptionBox($title, $include_file, $column = 'main'){
    # if the box file does not exists we are wrong here
    if (!is_File($include_file)) return False;

    # Title cannot be empty
    if (empty($title)) $title = '&nbsp;';

    # Column (can be 'side' or 'main')
    if ($column != 'main') $column = 'side';

    # Add a new box
    self::$arr_option_box[$column][] = (Object) Array(
      'title' => $title,
      'file' => $include_file
    );
  }

  static function get($key = Null, $default = False){
    # Read Options
    $saved_options = get_Option(self::options_key);
    setType($saved_options, 'ARRAY');
    $default_options = self::getDefaultOptions();
    $arr_option = Array_Merge($default_options, $saved_options);

    # Locate the option
    if (empty($key))
      return $arr_option;
    elseif (isSet($arr_option[$key]))
      return $arr_option[$key];
    else
      return $default;
  }

  static function saveOptions(){
    # Check if this is a post request
    if (empty($_POST)) return False;

    # Add Capabilities
    if (isSet($_POST['capabilities']) && is_Array($_POST['capabilities'])){
      foreach ($_POST['capabilities'] as $role_name => $arr_role){
        setType($arr_role, 'ARRAY');
        if (!$role = get_Role($role_name)) continue;
        foreach ($arr_role as $capability => $yes_no){
          if ($yes_no == 'yes')
            $role->add_Cap($capability);
          else
            $role->remove_Cap($capability);
        }
      }
      unset($_POST['capabilities']);
    }

    # Clean the Post array
    $options = stripSlashes_Deep($_POST);
    $options = Array_Filter($options, function($value){ return $value == '0' || !empty($value); });

    # Save Options
    update_Option(self::options_key, $options);

    return True;
  }

  static function getDefaultOptions(){
    return Array(
      'encyclopedia_type' => 'encyclopedia',
      'embed_default_style' => True,

      'enable_editor' => True,
      'enable_excerpt' => True,
      'enable_revisions' => False,
      'enable_comments' => False,
      'enable_thumbnail' => True,
      'enable_custom_fields' => False,

      'encyclopedia_categories' => True,
      'encyclopedia_tags' => True,

      'terms_per_page' => get_Option('posts_per_page'),
      'prefix_filter_for_archives' => True,
      'prefix_filter_archive_depth' => 3,

      'redirect_user_to_search_term' => True,
      'autocomplete_min_length' => 2,
      'autocomplete_delay' => 400,

      'related_terms' => 'below',
      'number_of_related_terms' => 5,
      'prefix_filter_for_singulars' => True,
      'prefix_filter_singular_depth' => 3,

      'link_terms' => Array(),
      'link_term_target' => Array(),
      'link_complete_words_only' => False,
      'link_terms_case_sensitive' => False,
      'link_terms_once' => False,
      'link_term_in_its_content' => False,
      'cross_link_title_length' => apply_Filters('excerpt_length', 55),

      'cross_linker_priority' => 'after_shortcodes',

      'update_username' => '',
      'update_password' => ''
    );
  }

}

Options::init();
