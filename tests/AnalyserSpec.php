<?php

use Axm\GetSetAnnotations\Analyser;
use Axm\GetSetAnnotations\ClassInfo;

describe(Analyser::class, function () {
    describe('::path', function () {
        it('returns an array of ClassInfos', function () {
            $classInfos = Analyser::path(SAMPLE_CLASS_PATH);
            expect($classInfos)->toBeAn('array');
            expect($classInfos)->toHaveLength(2);

            foreach ($classInfos as $classInfo) {
                expect($classInfo)->toBeAnInstanceOf(ClassInfo::class);
            }
        });
    });
});
