<input
    type="<?php echo $field->get_input_type(); ?>"
    name="<?php echo $field->name; ?>"
    id="<?php echo $field->id; ?>"
    class="<?php echo $field->css_class; ?>"
    value="<?php echo $value; ?>"
    <?php echo $field->data_attributes; ?>
    />
