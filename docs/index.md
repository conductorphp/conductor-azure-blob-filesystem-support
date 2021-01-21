Conductor Microsoft Azure Blob Filesystem Support
=================================================

This module adds [Conductor](https://github.com/conductorphp/conductor-core) 
support for Microsoft Azure Blob filesystem.

## Installation
```bash
composer require conductor/azure-blob-filesystem-support
```

## Basic Usage

<!-- @todo Add basic usage -->


## Configuration

```yaml
filesystem:
  adapters:
    myazureadapter:
      class: League\Flysystem\Azure\AzureAdapter
      arguments:
        client:
          account_key: myaccountkey
          account_name: myaccountname
        container: mycontainer
        prefix: ''
```

## Known Issues

The implementation of league/flysystem-azure is behind on the Microsoft Azure PHP SDK. It's locked to ~0.10.1 and the
latest at the time of writing this is 1.0.0 of microsoft/azure-storage-blob. The included version does not actually
stream files when downloading, often resulting in memory exhaustion errors. See
https://github.com/thephpleague/flysystem-azure/issues/17
