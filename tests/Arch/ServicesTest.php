<?php

declare(strict_types=1);


arch('services')
    ->expect(getServicesNamespaces())
    ->toBeFinal()
    ->toBeReadonly()
    ->toBeClasses()
    ->toUseStrictTypes()
    ->toOnlyBeUsedIn(getControllerNamespaces());;
