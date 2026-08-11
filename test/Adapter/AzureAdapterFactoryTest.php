<?php

namespace ConductorAzureBlobFilesystemSupportTest\Adapter;

use AzureOss\Storage\Blob\BlobContainerClient;
use AzureOss\Storage\BlobFlysystem\AzureBlobStorageAdapter;
use ConductorAzureBlobFilesystemSupport\Adapter\AzureAdapterFactory;
use ConductorAzureBlobFilesystemSupport\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionClass;

/**
 * There is no live storage account in CI, so these cover construction and option
 * validation rather than I/O. That is enough to catch the thing most likely to
 * break: an azure-oss SDK upgrade changing the client or adapter constructors.
 */
class AzureAdapterFactoryTest extends TestCase
{
    private AzureAdapterFactory $factory;
    private ContainerInterface $container;

    public function setUp(): void
    {
        $this->factory = new AzureAdapterFactory();
        // The factory builds everything from $options and never touches the container.
        $this->container = $this->createStub(ContainerInterface::class);
    }

    public function testBuildsAnAdapterBackedByABlobContainerClient()
    {
        $adapter = ($this->factory)($this->container, AzureBlobStorageAdapter::class, $this->validOptions());

        $this->assertInstanceOf(AzureBlobStorageAdapter::class, $adapter);
        $this->assertInstanceOf(BlobContainerClient::class, $this->containerClientOf($adapter));
    }

    public function testPrefixIsOptional()
    {
        $options = $this->validOptions();
        unset($options['prefix']);

        $this->assertInstanceOf(
            AzureBlobStorageAdapter::class,
            ($this->factory)($this->container, AzureBlobStorageAdapter::class, $options)
        );
    }

    public function testRejectsMissingRequiredOptions()
    {
        $options = $this->validOptions();
        unset($options['container']);

        $this->expectException(Exception\InvalidArgumentException::class);
        ($this->factory)($this->container, AzureBlobStorageAdapter::class, $options);
    }

    public function testRejectsUnknownOptions()
    {
        $this->expectException(Exception\InvalidArgumentException::class);
        ($this->factory)(
            $this->container,
            AzureBlobStorageAdapter::class,
            $this->validOptions() + ['bogus' => true]
        );
    }

    private function validOptions(): array
    {
        return [
            'client' => [
                'account_name' => 'testaccount',
                'account_key' => base64_encode('test-key'),
            ],
            'container' => 'test-container',
            'prefix' => 'some/prefix',
        ];
    }

    private function containerClientOf(AzureBlobStorageAdapter $adapter): object
    {
        return (new ReflectionClass($adapter))->getProperty('containerClient')->getValue($adapter);
    }
}
