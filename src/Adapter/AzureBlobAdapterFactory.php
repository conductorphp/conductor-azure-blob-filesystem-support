<?php

namespace DevopsToolAzureBlobFilesystemSupport\Adapter;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use League\Flysystem\Azure\AzureAdapter;
use MicrosoftAzure\Storage\Blob\Internal\IBlob;
use MicrosoftAzure\Storage\Common\ServicesBuilder;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AzureBlobAdapterFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     *
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $endpoint = sprintf(
            'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
            $options['account_name'],
            $options['api_key']
        );

        /** @var IBlob $blobRestProxy */
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($endpoint);

        return new AzureAdapter($blobRestProxy, $options['container']);
    }
}
