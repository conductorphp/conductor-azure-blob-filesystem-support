<?php

namespace ConductorAzureBlobFilesystemSupport;

return [
    'factories' => [
        \League\Flysystem\Azure\AzureAdapter::class => Adapter\AzureAdapterFactory::class,
    ],
];
