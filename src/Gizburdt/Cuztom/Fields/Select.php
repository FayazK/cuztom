<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Selectable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Select extends Field
{
    use Selectable;

    /**
     * View name.
     * @var string
     */
    public $view = 'select';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'     => 'cuztom-input-select',
        'row_css_class' => 'cuztom-field-select'
    );
}
