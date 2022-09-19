<?php

use Axm\GetSetAnnotations\ClassInfo;
use Axm\GetSetAnnotations\PropertyInfo;
use Axm\GetSetAnnotations\Test\sampleClass\DeltaClass;

describe(PropertyInfo::class, function () {

    beforeAll(function () {
        $classInfo = new ClassInfo(DeltaClass::class, SAMPLE_CLASS_PATH . 'DeltaClass.php');
        $this->properties = [];
        foreach ($classInfo->getProperties() as $property) {
            $this->properties[$property->getName()] = $property;
        }
    });

    describe('->getName', function () {
        it('returns the property name', function () {
            foreach ($this->properties as $name => $propertyInfo) {
                expect($propertyInfo->getName())->toBe($name);
            }
        });
    });

    describe('->getType', function () {
        it('returns type for the property', function () {
            $data = [
                'integer' => 'int',
                'float' => 'float',
                'double' => 'double',
                'array' => 'array',
                'bool' => 'bool',
                'Date' => 'DateTimeInterface|null',
                'null' => 'null',
            ];

            foreach ($data as $name => $type) {
                $propertyInfo = $this->properties[$name];
                expect($propertyInfo->getType())->toBe($type);
            }
        });
    });

    describe('->getGetterFuncName', function () {
        it('returns the getter function name', function () {
            $data = [
                'integer' => 'getInteger',
                'float' => 'getFloat',
                'double' => 'getDouble',
                'array' => 'getArray',
                'bool' => 'getBool',
                'Date' => 'getDate',
                'null' => 'getNull',
            ];

            foreach ($data as $name => $funcName) {
                $propertyInfo = $this->properties[$name];
                expect($propertyInfo->getGetterFuncName())->toBe($funcName);
            }
        });
    });

    describe('->getSetterFuncName', function () {
        it('returns the setter function name', function () {
            $data = [
                'integer' => 'setInteger',
                'float' => 'setFloat',
                'double' => 'setDouble',
                'array' => 'setArray',
                'bool' => 'setBool',
                'Date' => 'setDate',
                'null' => 'setNull',
            ];

            foreach ($data as $name => $funcName) {
                $propertyInfo = $this->properties[$name];
                expect($propertyInfo->getSetterFuncName())->toBe($funcName);
            }
        });
    });

    describe('->isMissingSetterMethod', function () {
        xit('returns an array of properties missing methods', function () {
            foreach ($this->properties as $name => $propertyInfo) {
                expect($propertyInfo)->toBe($name);
            }
        });
    });
    describe('->isMissingGetterMethod', function () {
        xit('returns an array of properties missing methods', function () {
            foreach ($this->properties as $name => $propertyInfo) {
                expect($propertyInfo)->toBe($name);
            }
        });
    });
});
