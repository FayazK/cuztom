<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Field\Accordion;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Support\Traits\HandlesAttributes;

Guard::directAccess();

abstract class Field
{
    use HandlesAttributes;

    /**
     * Fillables.
     *
     * @var mixed
     */
    public $id = null;

    /**
     * Before/after id/name.
     *
     * @var mixed
     */
    public $before_name = '';
    public $after_name  = '';
    public $before_id   = '';
    public $after_id    = '';

    /**
     * Base.
     *
     * @var mixed
     */
    public $object     = null;
    public $value      = null;
    public $meta_type  = null;
    public $view       = 'text';
    public $input_type = 'text';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes;

    /**
     * Casts.
     * @var array
     */
    protected $casts = array(
        'args'            => 'array',
        'options'         => 'array',
        'data_attributes' => 'array',
    );

    /**
     * Fillable by user.
     *
     * @var array
     */
    protected $fillable = array(
        'id',
        'type',
        'label',
        'description',
        'explanation',
        'default_value',
        'options',
        'args',
        'required',
        'repeatable',
        'limit',
        'ajax',
        'data_attributes',
        'css_class',
        'row_css_class',
        'show_admin_column',
        'admin_column_sortable',
        'admin_column_filter',

        // Special
        'parent',
        'fields',
        'panels',
        'title',
        'index'
    );

    /**
     * Constructs a Cuztom_Field.
     *
     * @param array $args
     * @param array $values
     * @since 0.3.3
     */
    public function __construct($args, $values = null)
    {
        // Set all attributes
        foreach ($this->fillable as $attribute) {
            $this->$attribute = isset($args[$attribute]) ? $args[$attribute] : @$this->attributes[$attribute];
        }

        // Repeatable?
        if ($this->is_repeatable()) {
            $this->after_name = '[]';
        }

        // Value
        $this->value = $this->substract_value($values);
    }

    /**
     * Outputs a field row.
     *
     * @param string|array $value
     * @pram  string       $view
     * @since 0.2
     */
    public function output_row($value = null)
    {
        return Cuztom::view('fields/row/text', array(
            'field' => $this,
            'value' => $value
        ));
    }

    /**
     * Output based on type.
     *
     * @param  string|array $value
     * @param  string       $value
     * @return string
     * @since  0.2
     */
    public function output($value = null)
    {
        $value = (! is_null($value)) ? $value : $this->value;

        if ($this->is_repeatable()) {
            return $this->_output_repeatable($value);
        } elseif ($this->is_ajax()) {
            return $this->_output_ajax($value);
        } else {
            return $this->_output($value);
        }
    }

    /**
     * Output field.
     *
     * @param  string|array $value
     * @param  string       $view
     * @return string
     * @since  2.4
     */
    public function _output($value = null)
    {
        return $this->_output_input($value).$this->explanation;
    }

    /**
     * Output input field.
     *
     * @param  string $value
     * @param  string $view
     * @return string
     */
    public function _output_input($value = null, $view = null)
    {
        $view = $view ? $view : $this->get_view();

        return Cuztom::view('fields/'.$view, array(
            'field' => $this,
            'value' => $value
        ));
    }

    /**
     * Outputs the field, ready for repeatable functionality.
     *
     * @param  mixed  $value
     * @param  string $view
     * @return string
     * @since  2.0
     */
    public function _output_repeatable($value = null)
    {
        return Cuztom::view('fields/repeatable/repeatable', array(
            'field'  => $this,
            'values' => $value,
            'count'  => 0
        ));
    }

    /**
     * Outputs repeatable item.
     *
     * @param  mixed  $value Default value
     * @param  int    $count Total count of fields
     * @return string
     */
    public function _output_repeatable_item($value = null, $count = 0)
    {
        return Cuztom::view('fields/repeatable/item', array(
            'field' => $this,
            'value' => $value,
            'count' => $count
        ));
    }

    /**
     * Outputs repeatable control.
     *
     * @param  mixed  $value
     * @return string
     * @since  3.0
     */
    public function _output_repeatable_control($value)
    {
        return Cuztom::view('fields/repeatable/control', array(
            'field' => $this,
            'value' => $value,
            'count' => count($value)
        ));
    }

    /**
     * Outputs the field, ready for ajax save.
     *
     * @param  mixed  $value
     * @return string
     * @since  2.0
     */
    public function _output_ajax($value = null)
    {
        return $this->_output($value).$this->_output_ajax_button();
    }

    /**
     * Outputs ajax save button.
     *
     * @return string
     * @since  3.0
     */
    public function _output_ajax_button()
    {
        return sprintf('<a class="cuztom-ajax-save js-cuztom-ajax-save button button-secondary button-small" href="#">%s</a>', __('Save', 'cuztom'));
    }

    /**
     * Parse value.
     *
     * @param  mixed $value.
     * @return mixed
     * @since  2.8
     */
    public function parse_value($value)
    {
        return $value;
    }

    /**
     * Save meta.
     *
     * @param  int   $object
     * @param  mixed $value
     * @return bool
     * @since  1.6.2
     */
    public function save($object, $values)
    {
        $value = $this->parse_value(@$values[$this->id]);

        // Save to respective content-type
        switch ($this->meta_type) {
            case 'user':
                update_user_meta($object, $this->id, $value);

                return true;
            break;
            case 'term':
                update_term_meta($object, $this->id, $value);

                return true;
            break;
            case 'post': default:
                update_post_meta($object, $this->id, $value);

                return true;
            break;
        }

        // Default
        return false;
    }

    /**
     * Returns the input type.
     *
     * @return string
     * @since  3.0
     */
    public function get_input_type()
    {
        return apply_filters('cuztom_field_input_type', $this->input_type, $this);
    }

    /**
     * Returns the view name.
     *
     * @return string
     * @since  3.0
     */
    public function get_view()
    {
        return apply_filters('cuztom_field_view', $this->view, $this);
    }

    /**
     * Get the complete id.
     *
     * @return string
     * @since  3.0
     */
    public function getIdAttribute($extra = null)
    {
        return apply_filters('cuztom_field_id', $this->before_id.$this->id.$this->after_id, $this, $extra);
    }

    /**
     * Get the complete name.
     *
     * @return string
     * @since  3.0
     */
    public function getNameAttribute()
    {
        return apply_filters('cuztom_field_name', 'cuztom'.$this->before_name.'['.$this->id.']'.$this->after_name, $this);
    }

    /**
     * Get the fields css classes.
     *
     * @param  array  $extra
     * @return string
     * @since  2.4
     */
    public function getCssClassAttribute($extra = null)
    {
        return apply_filters('cuztom_field_css_class', 'cuztom-input '.$this->attributes['css_class'], $this, $extra);
    }

    /**
     * Get the fields row css classes.
     *
     * @param  array  $extra
     * @return string
     * @since  3.0
     */
    public function getRowCssClassAttribute($extra = null)
    {
        return apply_filters('cuztom_field_row_css_class', 'cuztom-field js-cuztom-field '.$this->attributes['row_css_class'], $this, $extra);
    }

    /**
     * Outputs the fields explanation.
     *
     * @return string
     * @since  2.4
     */
    public function getExplanationAttribtue()
    {
        return apply_filters('cuztom_field_explanation', (! $this->is_repeatable() && $this->explanation ? '<em class="cuztom-field-explanation">'.$this->explanation.'</em>' : ''), $this);
    }

    /**
     * Outputs the fields data attributes.
     *
     * @param  array  $extra
     * @return string
     * @since  2.4
     */
    public function getDataAttributesAttribute($extra = array())
    {
        $attributes = $this->attributes['data_attributes'];

        if (is_array($attributes)) {
            foreach (array_merge($attributes, $extra) as $attribute => $value) {
                if (! is_null($value)) {
                    @$output .= ' data-'.$attribute.'="'.$value.'"';
                } elseif (! $value && isset($this->args[Cuztom::uglify($attribute)])) {
                    @$output .= 'data-'.$attribute.'="'.$this->args[Cuztom::uglify($attribute)].'"';
                }
            }
        }

        return apply_filters('cuztom_field_data_attributes', @$output, $this, $extra);
    }

    /**
     * Outputs the fields column content.
     *
     * @param int $post_id
     * @since 3.0
     */
    public function output_column_content($post_id)
    {
        $meta = get_post_meta($post_id, $this->id, true);

        if (! empty($meta) && $this->is_repeatable()) {
            echo implode($meta, ', ');
        } else {
            echo $meta;
        }
    }

    /**
     * Check what kind of meta we're dealing with.
     *
     * @param  string $meta_type
     * @return bool
     * @since  3.0
     */
    public function is_meta_type($meta_type)
    {
        return $this->meta_type == $meta_type;
    }

    /**
     * check if the field is in ajax mode.
     *
     * @return bool
     * @since  3.0
     */
    public function is_ajax()
    {
        return $this->ajax;
    }

    /**
     * Check if the field is in repeatable mode.
     *
     * @return bool
     * @since  3.0
     */
    public function is_repeatable()
    {
        return $this->repeatable;
    }

    /**
     * Check if the field is tabs or accordion.
     *
     * @return bool
     * @since  3.0
     */
    public function is_tabs()
    {
        return $this instanceof \Gizburdt\Cuztom\Fields\Tabs || $this instanceof \Gizburdt\Cuztom\Fields\Accordion;
    }

    /**
     * Check if the field is tabs or accordion.
     *
     * @return bool
     * @since  3.0
     */
    public function is_bundle()
    {
        return $this instanceof \Gizburdt\Cuztom\Fields\Bundle;
    }

    /**
     * Substract value of field from values array.
     *
     * @param  [type] $values [description]
     * @return [type] [description]
     */
    public function substract_value($values)
    {
        if (! Cuztom::is_empty(@$values[$this->id])) {
            if (is_array($values[$this->id])) {
                return maybe_unserialize(@$values[$this->id][0]);
            } else {
                return maybe_unserialize(@$values[$this->id]);
            }
        } else {
            return $this->default_value;
        }
    }

    // public function build()
    // {
    //     return $this;
    // }

    /**
     * Creates and returns a field object.
     *
     * @param  array       $args
     * @return object|bool
     * @since  3.0
     */
    public static function create($args, $values)
    {
        $type  = is_array($args) ? $args['type'] : $args;
        $class = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        $class = "Gizburdt\\Cuztom\\Fields\\$class";

        if (class_exists($class)) {
            return new $class($args, $values);
        }

        return false;
    }
}
