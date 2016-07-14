<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Wysiwyg extends Field
{
    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'row_css_class' => 'cuztom-field-wysiwyg'
    );

    /**
     * Output input.
     *
     * @param  string|array $value
     * @return string
     * @since  2.4
     */
    public function _output_input($value = null, $view = null)
    {
        // Needs to be set here, to work with sortables
        $args = array_merge(
            array(
                'textarea_name' => $this->get_name(),
                'editor_class'  => 'cuztom-input'
            ),
            $this->args
        );

        return wp_editor(
            (! Cuztom::is_empty($value) ? $value : $this->default_value),
            strtolower($this->get_id()),
            $args
        );
    }
}
