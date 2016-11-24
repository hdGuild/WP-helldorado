<?php Namespace WordPress\Plugin\Encyclopedia ?>

<table class="form-table">
<tr>
	<th><label for="encyclopedia_type"><?php echo I18n::t('Encyclopedia type') ?></label></th>
	<td>
		<select name="encyclopedia_type" id="encyclopedia_type">
			<?php foreach (Encyclopedia_Type::getEncyclopediaTypes() as $name => $type): ?>
			<option value="<?php echo $name ?>" <?php selected(Options::get('encyclopedia_type'), $name) ?> ><?php echo $type->label ?></option>
			<?php endforeach ?>
		</select>
		<p class="help"><?php echo I18n::t('Please choose the type of your encyclopedia. This option does not change the behavior of the plugin. It controls the labels, captions and the URL slug of your archives, entries, taxonomies and feeds.') ?></p>
	</td>
</tr>

<tr>
  <th><label for="embed_default_style"><?php echo I18n::t('Default style') ?></label></th>
  <td>
		<select name="embed_default_style" id="embed_default_style">
			<option value="1" <?php selected(Options::get('embed_default_style')) ?> ><?php echo I18n::t('On') ?></option>
			<option value="0" <?php selected(!Options::get('embed_default_style')) ?> ><?php echo I18n::t('Off') ?></option>
		</select>
		<p class="help"><?php echo I18n::t('Enables or disables the encyclopedia default stylesheet on the frontend.') ?></p>
	</td>
</tr>
</table>
