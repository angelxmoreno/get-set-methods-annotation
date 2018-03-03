<?php

namespace Axm\GetSetAnnotations;

use Rakshazi\GetSetTrait;

/**
 * Class ClassInfo
 *
 * @package Axm\GetSetAnnotations
 *
 * @method string getPath()
 * @method void setPath(string $path)
 * @method string getFqn()
 * @method void setFqn(string $fqn)
 * @method \ReflectionClass getReflector()
 * @method void setReflector(\ReflectionClass $reflector)
 * @method PropertyInfo[] getProperties()
 * @method void setProperties(PropertyInfo [] $properties)
 * @method string getDocBlock()
 * @method void setDocBlock(string $doc_block)
 */
class ClassInfo
{
    use GetSetTrait;

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
     * @var \ReflectionClass
     */
    protected $reflector;

    /**
     * @var PropertyInfo[]
     */
    protected $properties;

    /**
     * @var string
     */
    protected $doc_block;

    /**
     * ClassInfo constructor.
     *
     * @param string $fqn
     *
     * @throws \ReflectionException
     */
    public function __construct($fqn)
    {
        $reflector = new \ReflectionClass($fqn);

        $this->setFqn($fqn);
        $this->setReflector($reflector);
        $this->setPath($reflector->getFileName());
        $this->assignPropertyInfo($reflector);
        $this->setDocBlock($this->getMissingMethodDoc());
        $this->getDocMethods();
    }

    /**
     * @return string
     */
    protected function getMissingMethodDoc()
    {
        $doc = '';

        collection($this->getProperties())
            ->each(function (PropertyInfo $property_info) use (&$doc) {

                if ($property_info->getNeedsGetter()) {
                    $doc .= "\n";
                    $doc .= sprintf(
                        '* @method %s %s()',
                        $property_info->getType(),
                        $property_info->getGetterFuncName()
                    );
                }
                
                if ($property_info->getNeedsSetter()) {
                    $doc .= "\n";
                    $doc .= sprintf(
                        '* @method void %s(%s $%s)',
                        $property_info->getSetterFuncName(),
                        $property_info->getType(),
                        $property_info->getName()
                    );
                }
            });

        return $doc;
    }

    /**
     * @param \ReflectionClass $reflection_class
     */
    protected function assignPropertyInfo(\ReflectionClass $reflection_class)
    {
        $methods = collection($reflection_class->getMethods(\ReflectionMethod::IS_PUBLIC))
            ->filter(function (\ReflectionMethod $r_method) {
                return $r_method->getDeclaringClass()->getName() === $this->getFqn();
            })->map(function (\ReflectionMethod $r_method) {
                return $r_method->getName();
            })->toArray();

        $protected_props = collection($reflection_class->getProperties(\ReflectionProperty::IS_PROTECTED))
            ->filter(function (\ReflectionProperty $r_property) {

                return $r_property->getDeclaringClass()->getName() === $this->getFqn();
            })->map(function (\ReflectionProperty $r_property) use ($methods) {
                $property_info = new PropertyInfo($r_property);

                $property_info->setNeedsGetter(
                    !in_array($property_info->getGetterFuncName(), $methods)
                    && !in_array($property_info->getGetterFuncName(), $this->getDocMethods())
                );
                $property_info->setNeedsSetter(
                    !in_array($property_info->getSetterFuncName(), $methods)
                    && !in_array($property_info->getSetterFuncName(), $this->getDocMethods())
                );

                return $property_info;
            })->filter(function (PropertyInfo $property_info) {

                return $property_info->getNeedsGetter() || $property_info->getNeedsSetter();
            })->toArray();


        $this->setProperties($protected_props);
    }

    /**
     * @return array
     */
    protected function getDocMethods()
    {
        preg_match_all(self::PATTERN_METHOD_IN_DOCBLOCK, $this->getReflector()->getDocComment(), $matches);

        return $matches[1];
    }
}
