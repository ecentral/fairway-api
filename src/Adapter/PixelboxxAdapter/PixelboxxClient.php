<?php

declare(strict_types=1);

/*
 * This file is part of the "fairway_api" library by eCentral GmbH.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\FairwayFilesystemApi\Adapter\PixelboxxAdapter;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

final class PixelboxxClient
{
    private ClientInterface $client;
    private array $defaultConfiguration = [];
    private array $configuration = [];
    private string $baseUrl;

    public function __construct(string $baseUrl, array $configuration = [])
    {
        $this->baseUrl = $baseUrl;
        $this->configuration = $configuration;
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
