<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class File extends Field
{
    /**
     * Input type.
     * @var string
     */
    public $input_type = 'hidden';

    /**
     * View name.
     * @var string
     */
    public $view = 'file';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'     => 'cuztom-input-hidden',
        'row_css_class' => 'cuztom-field-file'
    );

    /**
     * Data attributes.
     * @var array
     */
    public $data_attributes = array('media-type' => 'file');
}
