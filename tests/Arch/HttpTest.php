<?php

declare(strict_types = 1);

arch('controllers')
    ->expect(getControllerNamespaces())
    ->toHaveSuffix('Controller')
    ->toHaveConstructor()
    ->toUseStrictTypes();

