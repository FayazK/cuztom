<?php

namespace Gizburdt\Cuztom\Support\Traits;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

trait HandlesAttributes
{
    /**
     * Magic setter.
     *
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Magic getter.
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->hasAccessor($name)) {
            return $this->{$this->getAccessorName($name)}();
        }

        if ($this->hasCaster($name)) {
            return $this->cast($name);
        }

        return $this->attributes[$name];
    }

    /**
     * Checks if class has accessor.
     *
     * @param  string  $name
     * @return boolean
     */
    function hasAccessor($name)
    {
        return method_exists($this, $this->getAccessorName($name));
    }

    /**
     * Return accessor name.
     *
     * @param  string $name
     * @return string
     */
    function getAccessorName($name)
    {
        return 'get'.Cuztom::studly_case($name).'Attribute';
    }

    /**
     * Cast attribute.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return mixed
     */
    public function cast($name)
    {
        switch($this->casts[$name]) {
            case 'array':
                return (array) $this->attributes[$name];
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Check if attribute has a caster.
     *
     * @param  string  $name
     * @return boolean
     */
    public function hasCaster($name)
    {
        return array_key_exists($name, $this->casts);
    }
}
