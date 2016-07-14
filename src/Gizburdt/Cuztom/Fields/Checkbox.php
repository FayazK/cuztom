<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Checkbox extends Field
{
    use Checkable;

    /**
     * Input type.
     * @var string
     */
    public $input_type = 'checkbox';

    /**
     * View name.
     * @var string
     */
    public $view = 'checkbox';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'row_css_class' => 'cuztom-field-checkbox'
    );
}
