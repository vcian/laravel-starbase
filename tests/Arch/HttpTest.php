<?php

declare(strict_types = 1);

arch('controllers')
    ->expect(getControllerNamespaces())
    ->toUseStrictTypes()
    ->toHaveSuffix('Controller')
    ->toBeFinal()
    ->ignoring('App\Http\Controllers\Auth')
    ->toBeReadonly()
    ->ignoring('App\Http\Controllers\Auth')
    ->toBeClasses()
    ->toHaveConstructor()
    ->ignoring('App\Http\Controllers\Auth');

