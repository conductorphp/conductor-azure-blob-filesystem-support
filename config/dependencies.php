<?php

namespace DevopsToolAzureBlobFilesystemSupport;

return [
    'factories' => [
        \League\Flysystem\Azure\AzureAdapter::class => Adapter\AzureBlobAdapterFactory::class,
    ],
];
