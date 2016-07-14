<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Fields\Traits\Checkable;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class YesNo extends Field
{
    use Checkable;

    /**
     * Input type.
     * @var string
     */
    public $input_type = 'radio';

    /**
     * View name.
     * @var string
     */
    public $view = 'yes-no';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'     => 'cuztom-input-radio',
        'row_css_class' => 'cuztom-field-yesno'
    );
}
