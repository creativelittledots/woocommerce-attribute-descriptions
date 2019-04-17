<tr id="wc-attribute-description-field" class="form-field form-required">
	<th scope="row" valign="top">
		<label for="attribute_name"><?php _e('Description', 'woocommerce_attribute_descriptions_admin_field_label'); ?></label>
	</th>
	<td>
		<?php wp_editor($attribute_description, 'attribute_description'); ?>
		<p class="description"><?php _e('The description is not prominent by default; however, some themes may show it.', 'woocommerce_attribute_descriptions_admin_field_description'); ?></p>
	</td>
</tr>