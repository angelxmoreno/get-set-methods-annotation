<?php

namespace Axm\GetSetAnnotations;

use ReflectionProperty;

/**
 * Class PropertyInfo
 *
 * @package Axm\GetSetAnnotations
 *
 */
class PropertyInfo
{
    const PATTERN_PROPERTY_TYPE = '~@var\s+([^\s]+)~i';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var string
     */
    protected $getter_func_name;

    /**
     * @var string
     */
    protected $setter_func_name;

    /**
     * @var bool
     */
    protected $missing_setter_method = true;

    /**
     * @var bool
     */
    protected $missing_getter_method = true;

    /**
     * PropertyInfo constructor.
     *
     * @param ReflectionProperty $reflectionProperty
     * @param array $knowMethods
     */
    public function __construct(ReflectionProperty $reflectionProperty, $knowMethods = [])
    {
        $this->name = $reflectionProperty->getName();
        $getSetSuffix = CamelCase::convert($this->name);
        $this->getter_func_name = 'get' . $getSetSuffix;
        $this->setter_func_name = 'set' . $getSetSuffix;
        $this->missing_getter_method = !in_array($this->getter_func_name, $knowMethods);
        $this->missing_setter_method = !in_array($this->setter_func_name, $knowMethods);

        preg_match(self::PATTERN_PROPERTY_TYPE, $reflectionProperty->getDocComment(), $matches);
        $this->type = count($matches) == 2
            ? $matches[1]
            : 'null';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getGetterFuncName()
    {
        return $this->getter_func_name;
    }

    /**
     * @return string
     */
    public function getSetterFuncName()
    {
        return $this->setter_func_name;
    }

    /**
     * @return bool
     */
    public function isMissingSetterMethod()
    {
        return $this->missing_setter_method;
    }

    /**
     * @return bool
     */
    public function isMissingGetterMethod()
    {
        return $this->missing_getter_method;
    }
}
