<?php

use DI\ContainerBuilder;
use Services\LoanService;
use Controllers\LoanController;
use Validators\LoanValidator;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    LoanController::class => function (LoanService $service) {
        return new LoanController($service, new LoanValidator());
    },
]);

return $containerBuilder->build();
