<?php

use Axm\GetSetAnnotations\ClassInfo;
use Axm\GetSetAnnotations\PropertyInfo;
use Axm\GetSetAnnotations\Test\sampleClass\AlphaClass;

describe(ClassInfo::class, function () {
    beforeAll(function () {
        $this->classInfo = new ClassInfo(AlphaClass::class, SAMPLE_CLASS_PATH . 'AlphaClass.php');
    });

    describe('->hasMissingMethods', function () {
        it('returns an int of missing methods', function () {
            expect($this->classInfo->hasMissingMethods())->toBeTruthy();
        });
    });

    describe('->getPath', function () {
        it('returns the path of the class', function () {
            expect($this->classInfo->getPath())->toBe(SAMPLE_CLASS_PATH . 'AlphaClass.php');
        });
    });

    describe('->getFqn', function () {
        it('returns the full qualified name of the class', function () {
            expect($this->classInfo->getFqn())->toBe(AlphaClass::class);
        });
    });


    describe('->getProperties', function () {
        it('returns an array of properties missing methods', function () {
            $properties = $this->classInfo->getProperties();
            expect($properties)->toBeAn('array');
            expect($properties)->toHaveLength(3);

            foreach ($properties as $property) {
                expect($property)->toBeAnInstanceOf(PropertyInfo::class);
            }
        });
    });
});
