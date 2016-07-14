<tr>
    <th>
        <label for="<?php echo $field->id; ?>" class="cuztom-label"><?php echo $field->label; ?></label>
        <?php echo ($field->required ? ' <span class="cuztom-required">*</span>' : ''); ?>
        <div class="cuztom-field-description"><?php echo $field->description; ?></div>
    </th>
    <td class="<?php echo $field->row_css_class; ?>" data-id="<?php echo $field->id; ?>">
        <?php echo $field->output($value); ?>
    </td>
</tr>
