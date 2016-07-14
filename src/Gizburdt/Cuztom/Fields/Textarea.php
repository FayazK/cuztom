<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Textarea extends Field
{
    /**
     * View name.
     * @var string
     */
    public $view = 'textarea';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'     => 'cuztom-input-textarea',
        'row_css_class' => 'cuztom-field-textarea'
    );
}
