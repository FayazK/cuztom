<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkables;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Checkboxes extends Field
{
    use Checkables;

    /**
     * After name.
     * @var string
     */
    public $after_name = '[]';

    /**
     * Css class.
     * @var string
     */
    public $input_type = 'checkbox';

    /**
     * View name.
     * @var string
     */
    public $view = 'checkboxes';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'     => 'cuztom-input-checkbox',
        'row_css_class' => 'cuztom-field-checkboxes'
    );

    /**
     * Construct.
     *
     * @param array $args
     * @since 0.3.3
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->default_value = (array) $this->default_value;
    }
}
