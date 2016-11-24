<?php Namespace WordPress\Plugin\Encyclopedia ?>

<table class="form-table">
<tr>
  <th><label for="related_terms"><?php echo I18n::t('Display related terms') ?></label></th>
  <td>
		<input type="radio" name="related_terms" id="related_terms_below" value="below" <?php checked(Options::get('related_terms'), 'below') ?>> <label for="related_terms_below"><?php echo I18n::t('below the current entry') ?></label><br>
		<input type="radio" name="related_terms" id="related_terms_above" value="above" <?php checked(Options::get('related_terms'), 'above') ?>> <label for="related_terms_above"><?php echo I18n::t('above the current entry') ?></label><br>
		<input type="radio" name="related_terms" id="related_terms_none" value="none" <?php checked(Options::get('related_terms'), 'none') ?>> <label for="related_terms_none"><?php echo I18n::t('Do not show related terms.') ?></label>
	</td>
</tr>

<tr>
  <th><label for="number_of_related_terms"><?php echo I18n::t('Number of related terms') ?></label></th>
  <td>
    <input type="number" name="number_of_related_terms" id="number_of_related_terms" value="<?php echo Options::get('number_of_related_terms') ?>" min="1" max="<?php echo PHP_INT_MAX ?>" step="1">
    <p class="help"><?php echo I18n::t('Number of related terms which should be shown.') ?></p>
	</td>
</tr>

<tr>
  <th><label for="prefix_filter_for_singulars"><?php echo I18n::t('Prefix filter') ?></label></th>
  <td>
		<select name="prefix_filter_for_singulars" id="prefix_filter_for_singulars">
			<option value="1" <?php selected(Options::get('prefix_filter_for_singulars')) ?> ><?php echo I18n::t('On') ?></option>
			<option value="0" <?php selected(!Options::get('prefix_filter_for_singulars')) ?> ><?php echo I18n::t('Off') ?></option>
		</select>
		<p class="help"><?php echo I18n::t('Enables or disables the prefix filter above the encyclopedia term.') ?></p>
	</td>
</tr>

<tr>
	<th><label for="prefix_filter_singular_depth"><?php echo I18n::t('Prefix filter depth') ?></label></th>
	<td>
    <input type="number" name="prefix_filter_singular_depth" id="prefix_filter_singular_depth" value="<?php echo Options::get('prefix_filter_singular_depth') ?>" min="1" max="<?php echo PHP_INT_MAX ?>" step="1">
    <p class="help"><?php echo I18n::t('The depth of the prefix filter is usually the number of lines with prefixes which are shown.') ?></p>
  </td>
</tr>
</table>
