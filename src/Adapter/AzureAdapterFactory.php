<?php

namespace ConductorAzureBlobFilesystemSupport\Adapter;

use AzureOss\Storage\Blob\BlobServiceClient;
use AzureOss\Storage\BlobFlysystem\AzureBlobStorageAdapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use ConductorAzureBlobFilesystemSupport\Exception;
use Psr\Container\ContainerInterface;

class AzureAdapterFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): AzureBlobStorageAdapter {
        $this->validateOptions($options);

        $client = $options['client'];
        $azureContainer = $options['container'];
        $prefix = isset($options['prefix']) ? $options['prefix'] : null;

        $connectionString = sprintf(
            'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s;EndpointSuffix=core.windows.net',
            $client['account_name'],
            $client['account_key']
        );
        $containerClient = BlobServiceClient::fromConnectionString($connectionString)
            ->getContainerClient($azureContainer);
        return new AzureBlobStorageAdapter($containerClient, $prefix ?? '');
    }

    /**
     * @param array $options
     * @throws Exception\InvalidArgumentException if options invalid
     */
    private function validateOptions(array $options): void
    {
        $requiredOptions = ['client', 'container'];
        $allowedOptions = ['client', 'container', 'prefix'];

        $missingRequiredOptions = array_diff($requiredOptions, array_keys($options));
        if ($missingRequiredOptions) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Missing %s constructor options: %s',
                    AzureBlobStorageAdapter::class,
                    implode(', ', $missingRequiredOptions)
                )
            );
        }

        $disallowedOptions = array_diff(array_keys($options), $allowedOptions);
        if ($disallowedOptions) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Invalid %s constructor options: %s',
                    AzureBlobStorageAdapter::class,
                    implode(', ', $disallowedOptions)
                )
            );
        }
    }
}
