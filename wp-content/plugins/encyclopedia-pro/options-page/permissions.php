<?php Namespace WordPress\Plugin\Encyclopedia;

# load post type object
$post_type = get_Post_Type_Object(Post_Type::post_type_name);
if (!$post_type) return;

# User capabilities
$arr_capabilities = Array(
  $post_type->cap->edit_posts => I18n::t('Edit and create (own) terms'),
  $post_type->cap->edit_others_posts => I18n::t('Edit others terms'),
  $post_type->cap->edit_private_posts => I18n::t('Edit (own) private terms'),
  $post_type->cap->edit_published_posts => I18n::t('Edit (own) published terms'),

  $post_type->cap->delete_posts => I18n::t('Delete (own) terms'),
  $post_type->cap->delete_private_posts => I18n::t('Delete (own) private terms'),
  $post_type->cap->delete_published_posts => I18n::t('Delete (own) published terms'),
  $post_type->cap->delete_others_posts => I18n::t('Delete others terms'),

  $post_type->cap->publish_posts => I18n::t('Publish terms'),
  $post_type->cap->read_private_posts => I18n::t('View (others) private terms')
);

# Taxonomies
foreach (get_Object_Taxonomies(Post_Type::post_type_name) as $taxonomy){
  $taxonomy = get_Taxonomy($taxonomy);
  $arr_capabilities[$taxonomy->cap->manage_terms] = sprintf(I18n::t('Manage %s'), $taxonomy->labels->name);
}

# Show the user roles
foreach ($GLOBALS['wp_roles']->roles as $role_name => $arr_role): ?>
  <h4><?php echo Translate_User_Role($arr_role['name']) ?></h4>

  <?php foreach ($arr_capabilities as $capability => $caption): ?>
  <div class="capability-selection">
    <input type="hidden" name="capabilities[<?php echo $role_name ?>][<?php echo $capability ?>]" value="no">
    <input type="checkbox" name="capabilities[<?php echo $role_name ?>][<?php echo $capability ?>]" id="capabilities-<?php echo $role_name ?>-<?php echo $capability ?>" value="yes" <?php checked(isSet($arr_role['capabilities'][$capability])) ?> >
    <label for="capabilities-<?php echo $role_name ?>-<?php echo $capability ?>"><?php echo $caption ?></label>
  </div>
  <?php endforeach ?>

<?php endforeach;
