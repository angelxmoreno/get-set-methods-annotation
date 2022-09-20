# GetSet Methods Annotation

A CLI script for reporting missing getter/setter methods due to the use of magic methods. 

[![License](https://poser.pugx.org/angelxmoreno/get-set-annotations/license)](https://packagist.org/packages/angelxmoreno/get-set-annotations)
[![Total Downloads](https://poser.pugx.org/angelxmoreno/get-set-annotations/downloads)](https://packagist.org/packages/angelxmoreno/get-set-annotations)
[![Latest Stable Version](https://poser.pugx.org/angelxmoreno/get-set-annotations/v/stable)](https://packagist.org/packages/angelxmoreno/get-set-annotations)
[![Build Status](https://travis-ci.org/angelxmoreno/get-set-methods-annotation.svg?branch=master)](https://travis-ci.org/angelxmoreno/get-set-methods-annotation)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bf8b650e2be242259ee55dcb822d2052)](https://www.codacy.com/app/angelxmoreno/get-set-methods-annotation?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=angelxmoreno/get-set-methods-annotation&amp;utm_campaign=Badge_Grade)
[![Maintainability](https://api.codeclimate.com/v1/badges/f3474f14ef0800f8391e/maintainability)](https://codeclimate.com/github/angelxmoreno/get-set-methods-annotation/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/f3474f14ef0800f8391e/test_coverage)](https://codeclimate.com/github/angelxmoreno/get-set-methods-annotation/test_coverage)
## Why this project?

I really enjoy using the [GetSetTrait](https://github.com/mikebarlow/GetSet) provided by [mikebarlow](https://github.com/mikebarlow).
One of the issues with using magic getters and setters is that most IDEs lose knowledge about the class methods available. This can 
easily be addressed by adding proper `@method` entries to the class doc blocks. This can sometimes prove to be time consuming and open 
to typos. 

I created this CLI script to generate the `@method` entries for classes missing defined getters/setters. Thought it was created to
support the [GetSetTrait](https://github.com/mikebarlow/GetSet), it can be used for any implementation of magic getters and setters

## Installation
```bash
composer require --dev angelxmoreno/get-set-annotations
```

## Usage
````bash
./bin/get-set-scan [directory]
````

This prints out a report similar to the following:

```text
Classname : Axm\GetSetAnnotations\ClassInfo
Path : /Users/amoreno/Projects/AmzRouter/get-set-methods-annotation/src/ClassInfo.php
DocBlock : 
* @method void setPath(string $path)
* @method void setFqn(string $fqn)
* @method void setProperties(PropertyInfo[] $properties)
* @method void setHasMissingMethods(bool $has_missing_methods)
* @method bool getHasMissingMethods()
```


## Testing
tests can be run in two different ways; locally and using a docker container.

### Locally
```shell
composer tests:check
composer tests:coverage
```

### Using the built-in docker image
```shell
composer docker:tests:check
composer docker:tests:coverage
```

## Current test coverage
```text
Coverage Summary
----------------
                                                        Lines            %

 \                                                     45 / 71      63.38%
└── Axm\                                               45 / 71      63.38%
   └── GetSetAnnotations\                              45 / 71      63.38%
      ├── Analyser                                      7 /  7     100.00%
      │  ├── Analyser::buildClassInfosInPath()          6 /  6     100.00%
      │  └── Analyser::path()                           1 /  1     100.00%
      ├── CamelCase                                     2 /  3      66.67%
      │  └── CamelCase::convert()                       2 /  3      66.67%
      ├── ClassInfo                                    22 / 29      75.86%
      │  ├── ClassInfo::__construct()                   5 /  5     100.00%
      │  ├── ClassInfo::buildCurrentDocMethods()        2 /  2     100.00%
      │  ├── ClassInfo::buildMissingMethodsDoc()        0 /  7       0.00%
      │  ├── ClassInfo::buildPropertyInfoArray()       11 / 11     100.00%
      │  ├── ClassInfo::getFqn()                        1 /  1     100.00%
      │  ├── ClassInfo::getPath()                       1 /  1     100.00%
      │  ├── ClassInfo::getProperties()                 1 /  1     100.00%
      │  └── ClassInfo::hasMissingMethods()             1 /  1     100.00%
      ├── PropertyInfo                                 14 / 14     100.00%
      │  ├── PropertyInfo::__construct()                8 /  8     100.00%
      │  ├── PropertyInfo::getGetterFuncName()          1 /  1     100.00%
      │  ├── PropertyInfo::getName()                    1 /  1     100.00%
      │  ├── PropertyInfo::getSetterFuncName()          1 /  1     100.00%
      │  ├── PropertyInfo::getType()                    1 /  1     100.00%
      │  ├── PropertyInfo::isMissingGetterMethod()      1 /  1     100.00%
      │  └── PropertyInfo::isMissingSetterMethod()      1 /  1     100.00%
      └── Writer                                        0 / 18       0.00%
         ├── Writer::__construct()                      0 /  4       0.00%
         ├── Writer::outCli()                           0 /  3       0.00%
         ├── Writer::toCli()                            0 /  6       0.00%
         └── Writer::writeToFile()                      0 /  5       0.00%

Total: 63.38% (45/71)

Coverage collected in 0.069 seconds

```
# License

Copyright 2022 Angel S. Moreno (angelxmoreno). All rights reserved.

Licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.
