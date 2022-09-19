<?php

namespace Axm\GetSetAnnotations\Test\sampleClass;

class BetaClass
{
    public $public_property = 'public value';
    protected $protected_property = 'protected value';
    protected $no_getter_protected_property = 'protected value with no getter';
    protected $no_setter_protected_property = 'protected value with no setter';

    /**
     * @return string
     */
    public function getPublicProperty()
    {
        return $this->public_property;
    }

    /**
     * @param string $public_property
     */
    public function setPublicProperty($public_property)
    {
        $this->public_property = $public_property;
    }

    /**
     * @return string
     */
    public function getProtectedProperty()
    {
        return $this->protected_property;
    }

    /**
     * @param string $protected_property
     */
    public function setProtectedProperty($protected_property)
    {
        $this->protected_property = $protected_property;
    }

    /**
     * @return string
     */
    public function getNoGetterProtectedProperty()
    {
        return $this->no_getter_protected_property;
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
    public function getNoSetterProtectedProperty()
    {
        return $this->no_setter_protected_property;
    }

    /**
     * @param string $no_setter_protected_property
     */
    public function setNoSetterProtectedProperty($no_setter_protected_property)
    {
        $this->no_setter_protected_property = $no_setter_protected_property;
    }
}
