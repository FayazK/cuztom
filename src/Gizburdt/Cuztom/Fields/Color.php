<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Color extends Field
{
    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'     => 'cuztom-input-colorpicker colorpicker js-cuztom-colorpicker',
        'row_css_class' => 'cuztom-field-color'
    );
}
