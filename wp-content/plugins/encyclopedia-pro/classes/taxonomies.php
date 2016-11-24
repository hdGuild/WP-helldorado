<?php Namespace WordPress\Plugin\Encyclopedia;

abstract class Taxonomies {

  static function init(){
    add_Action('init', Array(__CLASS__, 'registerTaxonomies'), 9);
    add_Filter('nav_menu_meta_box_object', Array(__CLASS__, 'changeTaxonomyMenuLabel'));
    add_Action('init', Array(__CLASS__, 'addTaxonomyArchiveUrls'), 99);
  }

  static function registerTaxonomies(){
		if (Options::get('encyclopedia_categories')){
			register_Taxonomy('encyclopedia-category', Post_Type::post_type_name, Array(
				'label' => sprintf('%s: %s', Encyclopedia_Type::$type->label, __('Categories')),
				'labels' => Array(
					'name' => __('Categories'),
					'singular_name' => I18n::t('Category'),
					'search_items' =>  I18n::t('Search Categories'),
					'all_items' => I18n::t('All Categories'),
					'parent_item' => I18n::t('Parent Category'),
					'parent_item_colon' => I18n::t('Parent Category:'),
					'edit_item' => I18n::t('Edit Category'),
					'update_item' => I18n::t('Update Category'),
					'add_new_item' => I18n::t('Add New Category'),
					'new_item_name' => I18n::t('New Category')
				),
        'show_admin_column' => True,
				'hierarchical' => True,
				'show_ui' => True,
				'query_var' => True,
				'rewrite' => Array(
					'with_front' => False,
					'slug' => ltrim(sprintf(I18n::t('%s/category', 'URL slug'), Encyclopedia_Type::$type->slug), '/')
				),
				'capabilities' => Array (
					'manage_terms' => 'manage_encyclopedia_categories',
					'edit_terms' => 'manage_encyclopedia_categories',
					'delete_terms' => 'manage_encyclopedia_categories',
					'assign_terms' => 'edit_encyclopedia_terms'
				)
			));
		}

    if (Options::get('encyclopedia_tags')){
			register_Taxonomy('encyclopedia-tag', Post_Type::post_type_name, Array(
				'label' => I18n::t('Encyclopedia Tags'),
				'labels' => Array(
					'name' => I18n::t('Tags'),
					'singular_name' => I18n::t('Tag'),
					'search_items' =>  I18n::t('Search Tags'),
					'all_items' => I18n::t('All Tags'),
					'edit_item' => I18n::t('Edit Tag'),
					'update_item' => I18n::t('Update Tag'),
					'add_new_item' => I18n::t('Add New Tag'),
					'new_item_name' => I18n::t('New Tag')
				),
        'show_admin_column' => True,
				'hierarchical' => False,
				'show_ui' => True,
				'query_var' => True,
				'rewrite' => Array(
					'with_front' => False,
					'slug' => ltrim(sprintf(I18n::t('%s/tag', 'URL slug'), Encyclopedia_Type::$type->slug), '/')
				),
				'capabilities' => Array (
					'manage_terms' => 'manage_encyclopedia_tags',
					'edit_terms' => 'manage_encyclopedia_tags',
					'delete_terms' => 'manage_encyclopedia_tags',
					'assign_terms' => 'edit_encyclopedia_terms'
				)
			));
    }
  }

  static function changeTaxonomyMenuLabel($tax){
    if (isSet($tax->object_type) && in_Array(Post_Type::post_type_name, $tax->object_type)){
      $tax->labels->name = sprintf('%1$s &raquo; %2$s', Encyclopedia_Type::$type->label, $tax->labels->name);
    }
    return $tax;
  }

  static function addTaxonomyArchiveUrls(){
    foreach (get_Object_Taxonomies(Post_Type::post_type_name) as $taxonomy){
      add_Action($taxonomy.'_edit_form_fields', Array(__CLASS__, 'printTaxonomyArchiveUrls'), 10, 3);
    }
  }

  static function printTaxonomyArchiveUrls($tag, $taxonomy){
    $taxonomy = get_Taxonomy($taxonomy);
    $archive_url = get_Term_Link(get_Term($tag->term_id, $taxonomy->name));
    $archive_feed = get_Term_Feed_Link($tag->term_id, $taxonomy->name);
    ?>
    <tr class="form-field">
      <th scope="row" valign="top"><?php echo I18n::t('Archive Url') ?></th>
      <td>
        <code><a href="<?php echo $archive_url ?>" target="_blank"><?php echo $archive_url ?></a></code><br>
        <span class="description"><?php printf(I18n::t('This is the URL to the archive of this %s.'), $taxonomy->labels->singular_name) ?></span>
      </td>
    </tr>
    <tr class="form-field">
      <th scope="row" valign="top"><?php echo I18n::t('Archive Feed') ?></th>
      <td>
        <code><a href="<?php echo $archive_feed ?>" target="_blank"><?php echo $archive_feed ?></a></code><br>
        <span class="description"><?php printf(I18n::t('This is the URL to the feed of the archive of this %s.'), $taxonomy->labels->singular_name) ?></span>
      </td>
    </tr>
    <?php
  }

}

Taxonomies::init();
