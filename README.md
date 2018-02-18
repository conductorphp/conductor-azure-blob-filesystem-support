Conductor: Azure Blob Filesystem Support
===============================================

This module adds support for the Azure Blob filesystem in the   
[Conductor](https://github.com/conductorphp/conductor-core).

## Configuration

```php

return [
    'filesystem' => [
        'adapters' => [
            'myazureadapter' => [
                'class'     => \League\Flysystem\Azure\AzureAdapter::class,
                'arguments' => [
                    'client' => [
                        'account_key' => 'myaccountkey',
                        'account_name' => 'myaccountname',
                    ],
                    'container' => 'mycontainer',
                    'prefix' => '',
                ],
            ],
        ],
    ],
];
```
