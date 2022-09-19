<?php

namespace Axm\GetSetAnnotations\Test\sampleClass;

class AlphaClass
{
    public $public_property = 'public value';
    protected $protected_property = 'protected value';
    protected $no_getter_protected_property = 'protected value with no getter';
    protected $no_setter_protected_property = 'protected value with no setter';
    protected $protected_property_with_setter_and_getter = 'protected property with setter and getter';

    /**
     * @return string
     */
    public function getNoSetterProtectedProperty()
    {
        return $this->no_setter_protected_property;
    }

    /**
     * @param string $no_getter_protected_property
     */
    public function setNoGetterProtectedProperty($no_getter_protected_property)
    {
        $this->no_getter_protected_property = $no_getter_protected_property;
    }

    /**
     * @return string
     */
    public function getProtectedPropertyWithSetterAndGetter()
    {
        return $this->protected_property_with_setter_and_getter;
    }

    /**
     * @param string $protected_property_with_setter_and_getter
     */
    public function setProtectedPropertyWithSetterAndGetter($protected_property_with_setter_and_getter)
    {
        $this->protected_property_with_setter_and_getter = $protected_property_with_setter_and_getter;
    }
}
