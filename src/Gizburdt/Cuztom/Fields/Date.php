<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Date extends DateTime
{
    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'     => 'cuztom-input-date datepicker js-cuztom-datepicker',
        'row_css_class' => 'cuztom-field-date'
    );

    /**
     * UNIX time to string.
     *
     * @param  string $string
     * @return string
     */
    public function time_to_string($string)
    {
        return $string ? date(get_option('date_format'), $string) : null;
    }
}
