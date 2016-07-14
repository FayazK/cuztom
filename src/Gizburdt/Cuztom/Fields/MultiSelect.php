<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class MultiSelect extends Select
{
    use Selectable;

    /**
     * After name.
     * @var string
     */
    public $after_name = '[]';

    /**
     * View name.
     * @var string
     */
    public $view = 'multi-select';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'     => 'cuztom-input-select cuztom-input-multi-select',
        'row_css_class' => 'cuztom-field-multi-select'
    );

    /**
     * Construct.
     *
     * @param array $field
     * @since 0.3.3
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->args = array(
            'multiselect' => true
        );
    }
}
