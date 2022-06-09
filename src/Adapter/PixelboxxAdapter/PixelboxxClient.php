<?php
declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi\Adapter\PixelboxxAdapter;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

final class PixelboxxClient
{
    private ClientInterface $client;
    private array $defaultConfiguration = [];

    public function __construct(private readonly string $baseUrl, private array $configuration = [])
    {

    }

    public function authenticate(string $username, string $password)
    {
        $client = new Client($this->configuration);
        $response = $client->post(
            $this->getEndpoint('/authenticate/login'),
            [
                'auth' => [
                    $username,
                    $password
                ]
            ]
        );
        var_dump($response->getBody()->getContents());
    }

    private function getConfiguration(): array
    {
        return array_merge($this->defaultConfiguration, $this->configuration);
    }

    public function setConfiguration(array $configuration): self
    {
        $this->configuration = $configuration;
        return $this;
    }

    public function getEndpoint(string $endpoint): string
    {
        return sprintf('%s%s', rtrim($this->baseUrl, '/'), $endpoint);
    }
}
