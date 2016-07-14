<?php

namespace Gizburdt\Cuztom\Meta;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Support\Traits\HandlesAttributes;

Guard::directAccess();

abstract class Meta
{
    use HandlesAttributes;

    /**
     * ID.
     * @var string
     */
    public $id;

    /**
     * Callback.
     * @var array|string
     */
    public $callback;

    /**
     * Data.
     * @var array
     */
    public $data;

    /**
     * Object.
     * @var int
     */
    public $object;

    /**
     * Meta type.
     * @var string
     */
    public $meta_type;

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
        'fields' => 'array'
    );

    /**
     * Fillable.
     * @var array
     */
    protected $fillable = array(
        'title',
        'description',
        'fields',
    );

    /**
     * Get object id.
     *
     * @return int
     */
    abstract public function determine_object();

    /**
     * Get meta values.
     *
     * @return array
     */
    abstract public function get_meta_values();

    /**
     * Construct for all meta types, creates title (and description).
     *
     * @param int   $id   Box ID
     * @param array $args Array of fields
     * @since 1.6.4
     */
    public function __construct($id, $args)
    {
        global $cuztom;

        // Set all attributes
        foreach ($this->fillable as $attribute) {
            $this->$attribute = isset($args[$attribute]) ? $args[$attribute] : @$this->attributes[$attribute];
        }

        // Set hard
        $this->id     = $id;
        $this->object = $this->determine_object();
        $this->values = $this->get_meta_values();

        // Callback
        if (! $this->callback) {
            $this->callback = array(&$this, 'output');

            // Build the meta box and fields
            $this->data = $this->build($this->fields);

            // Assign global
            $cuztom->data[$this->id] = $this->data;
        }
    }

    /**
     * Main callback for meta.
     *
     * @since 0.2
     */
    public function output()
    {
        // Nonce field for validation
        wp_nonce_field('cuztom_meta', 'cuztom_nonce');

        echo Cuztom::view('meta/meta', array(
            'box' => $this
        ));
    }

    /**
     * Normal save method to save all the fields in a metabox.
     *
     * @param int   $object Object ID
     * @param array $values Array of values
     * @since 2.6
     */
    public function save($object, $values)
    {
        foreach ($this->data as $id => $field) {
            $field->save($object, $values);
        }
    }

    /**
     * Adds multipart support to form.
     *
     * @since 0.2
     */
    public function edit_form_tag()
    {
        echo ' enctype="multipart/form-data"';
    }

    /**
     * This method builds the complete array with the right key => value pairs.
     *
     * @param  array $fields
     * @return array
     * @since  1.1
     */
    public function build($fields)
    {
        if (is_array($fields) && ! Cuztom::is_empty($fields)) {
            foreach ($fields as $type => $args) {
                $field            = Field::create($args, $this->values);
                $field->meta_type = $this->meta_type;
                $field->object    = $this->object;

                $data[$field->id] = $field;
            }
        }

        return @$data;
    }
}
