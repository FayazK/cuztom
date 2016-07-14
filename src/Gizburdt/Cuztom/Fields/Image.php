<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Image extends Field
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
    public $view = 'image';

    /**
     * Attributes.
     * @var array
     */
    protected $attributes = array(
        'css_class'       => 'cuztom-input-hidden',
        'row_css_class'   => 'cuztom-field-image',
        'data_attributes' => array('media-type' => 'image')
    );

    /**
     * Output column content.
     *
     * @param  string $post_id
     * @return string
     * @since  3.0
     */
    public function output_column_content($post_id)
    {
        $meta = get_post_meta($post_id, $this->id, true);

        echo wp_get_attachment_image($meta, array(100, 100));
    }

    /**
     * Get preview size.
     *
     * @return string
     * @since  3.0
     */
    public function get_preview_size()
    {
        $size = (! Cuztom::is_empty($this->args['preview_size']) ? $this->args['preview_size'] : 'medium');

        return apply_filters('cuztom_field_image_preview_size', $size, $this);
    }
}
