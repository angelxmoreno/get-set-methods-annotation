<?php

namespace Axm\GetSetAnnotations;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Class ClassInfo
 *
 * @package Axm\GetSetAnnotations
 *
 */
class ClassInfo
{
    const PATTERN_METHOD_IN_DOCBLOCK = '~.+@method [^ ]+ ([^\(]+)~i';

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $fqn;

    /**
     * @var PropertyInfo[]
     */
    protected $properties = [];

    /**
     * @var bool
     */
    protected $has_missing_methods = true;

    /**
     * ClassInfo constructor.
     *
     * @param string $fqn
     * @param string $path
     *
     * @throws ReflectionException
     */
    public function __construct($fqn, $path)
    {
        $this->fqn = $fqn;
        $this->path = $path;
        $reflectionClass = new ReflectionClass($fqn);
        $this->properties = $this->buildPropertyInfoArray($reflectionClass);
        $this->has_missing_methods = count($this->properties) > 0;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return PropertyInfo[]
     */
    protected function buildPropertyInfoArray(ReflectionClass $reflectionClass)
    {
        $publicMethods = [];
        $reflectionMethods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($reflectionMethods as $reflectionMethod) {
            /**
             * @TODO why only the locally defined methods? In a case where the parent defines a getter or setter, do we
             * still need to add the doc block methods?
             */
            $definedLocally = $reflectionMethod->getDeclaringClass()->getName() === $reflectionClass->getName();
            if ($definedLocally) {
                $publicMethods[] = $reflectionMethod->getName();
            }
        }

        $propertiesInfo = [];
        $reflectionProperties = $reflectionClass->getProperties(ReflectionProperty::IS_PROTECTED);

        $knownMethods = array_merge($publicMethods, $this->buildCurrentDocMethods($reflectionClass));
        foreach ($reflectionProperties as $reflectionProperty) {
            $definedLocally = $reflectionProperty->getDeclaringClass()->getName() === $reflectionClass->getName();
            if ($definedLocally) {
                $propertyInfo = new PropertyInfo($reflectionProperty, $knownMethods);
                if ($propertyInfo->isMissingGetterMethod() || $propertyInfo->isMissingSetterMethod()) {
                    $propertiesInfo[] = $propertyInfo;
                }
            }
        }

        return $propertiesInfo;
    }

    /**
     * @return string[]
     */
    protected function buildCurrentDocMethods(ReflectionClass $reflectionClass)
    {
        preg_match_all(self::PATTERN_METHOD_IN_DOCBLOCK, $reflectionClass->getDocComment(), $matches);
        return $matches[1];
    }

    /**
     * @return string
     */
    public function buildMissingMethodsDoc($build_getters = true, $build_setters = true)
    {
        if (!$this->has_missing_methods) {
            return '';
        }

        $doc = '';
        foreach ($this->properties as $propertyInfo) {
            if ($propertyInfo->isMissingSetterMethod() && $build_setters) {
                $doc .= "\n";
                $doc .= sprintf(
                    '* @method void %s(%s $%s)',
                    $propertyInfo->getSetterFuncName(),
                    $propertyInfo->getType(),
                    $propertyInfo->getName()
                );
            }

            if ($propertyInfo->isMissingGetterMethod() && $build_getters) {
                $doc .= "\n";
                $doc .= sprintf(
                    '* @method %s %s()',
                    $propertyInfo->getType(),
                    $propertyInfo->getGetterFuncName()
                );
            }
        }

        return $doc;
    }

    /**
     * @return bool
     */
    public function hasMissingMethods()
    {
        return $this->has_missing_methods;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFqn()
    {
        return $this->fqn;
    }

    /**
     * @return PropertyInfo[]
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
