<?php Namespace WordPress\Plugin\Encyclopedia;

$link_terms = is_Array(Options::get('link_terms')) ? Options::get('link_terms') : Array();
$link_target = Options::get('link_term_target');

?>

<table class="form-table">

<?php foreach (get_Post_Types(Array('show_ui' => True),'objects') as $type): ?>
<tr>
  <th><?php echo $type->label ?></th>
  <td>
    <label for="link_terms_in_<?php echo $type->name ?>">
      <input type="checkbox" name="link_terms[]" value="<?php echo $type->name ?>" id="link_terms_in_<?php echo $type->name ?>" <?php checked(in_Array($type->name, $link_terms)) ?> >
      <?php printf(I18n::t('Link terms in %s'), $type->label) ?>
    </label><br>

    <label for="link_term_target_<?php echo $type->name ?>">
      <input type="checkbox" name="link_term_target[<?php echo $type->name ?>]" value="_blank" id="link_term_target_<?php echo $type->name ?>" <?php checked(isSet($link_target[$type->name])) ?> >
      <?php echo I18n::t('Open link in a new window/tab') ?>
    </label>
  </td>
</tr>
<?php endforeach ?>

<tr>
  <th><?php echo I18n::t('Filter order') ?></th>
  <td>
    <label for="cross_linker_priority">
      <select id="cross_linker_priority" name="cross_linker_priority">
        <option value="before_shortcodes" <?php selected(Options::get('cross_linker_priority') == 'before_shortcodes') ?> ><?php echo I18n::t('Before shortcodes') ?></option>
        <option value="" <?php selected(Options::get('cross_linker_priority') == 'after_shortcodes') ?> ><?php echo I18n::t('After shortcodes') ?></option>
      </select>
    </label>
    <p class="help"><?php echo I18n::t('By default the cross links should be added to the content after rendering all shortcodes. This works not for shortcodes which are calling the "the_content" filter while rendering. In this case please change this setting to "Before shortcodes".') ?></p>
  </td>
</tr>

<tr>
  <th><?php echo I18n::t('Complete words') ?></th>
  <td>
    <label for="link_complete_words_only">
      <input type="checkbox" name="link_complete_words_only" value="1" id="link_complete_words_only" <?php checked(Options::get('link_complete_words_only')) ?> >
      <?php echo I18n::t('Link complete words only.') ?>
    </label>
  </td>
</tr>

<tr>
  <th><?php echo I18n::t('Case sensitivity') ?></th>
  <td>
    <label for="link_terms_case_sensitive">
      <input type="checkbox" name="link_terms_case_sensitive" value="1" id="link_terms_case_sensitive" <?php checked(Options::get('link_terms_case_sensitive')) ?> >
      <?php echo I18n::t('Link terms case sensitive.') ?>
    </label>
  </td>
</tr>

<tr>
  <th><?php echo I18n::t('First match only') ?></th>
  <td>
    <label for="link_terms_once">
      <input type="checkbox" name="link_terms_once" value="1" id="link_terms_once" <?php checked(Options::get('link_terms_once')) ?> >
      <?php echo I18n::t('Link the first match of each term only.') ?>
    </label>
  </td>
</tr>

<tr>
  <th><?php echo I18n::t('Recursion') ?></th>
  <td>
    <label for="link_term_in_its_content">
      <input type="checkbox" name="link_term_in_its_content" value="1" id="link_term_in_its_content" <?php checked(Options::get('link_term_in_its_content')) ?> >
      <?php echo I18n::t('Link the term in its own content.') ?>
    </label>
  </td>
</tr>

<tr>
	<th><label for="cross_link_title_length"><?php echo I18n::t('Link title length') ?></label></th>
	<td>
		<input type="number" name="cross_link_title_length" id="cross_link_title_length" value="<?php echo Esc_Attr(Options::get('cross_link_title_length')) ?>"> <?php echo I18n::t('words') ?>
		<p class="help"><?php echo I18n::t('The number of words of the linked term used as link title. This option does not affect manually created excerpts.') ?></p>
	</td>
</tr>

</table>
