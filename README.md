Robofirm DevOps Tool: Azure Blob Filesystem Support
===============================================

This module adds support for the Azure Blob filesystem in the   
[Robofirm DevOps Tool](https://bitbucket.org/robofirm/robofirm-devops).

## Configuration

```php

return [
    'filesystem' => [
        'adapters' => [
            'myazureadapter' => [
                'api_key' => 'myapikey',
                'application_name' => 'myapplicationname',
                'container' => 'mycontainer',
            ],
        ],
    ],
];
```
