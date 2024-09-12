<?php

declare(strict_types = 1);

arch('controllers')
    ->expect(getControllerNamespaces())
    ->toUseStrictTypes()
    ->toHaveSuffix('Controller')
    ->toBeFinal()
    ->toBeReadonly()
    ->toBeClasses()
    ->toHaveConstructor();

