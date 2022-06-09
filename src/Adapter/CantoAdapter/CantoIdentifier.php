<?php

declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi\Adapter\CantoAdapter;

use JetBrains\PhpStorm\ArrayShape;
use Stringable;

final class CantoIdentifier implements Stringable
{
    private const SPLIT_IDENTIFIER = '<>';

    public function __construct(private readonly string $identifier)
    {
    }

    public static function buildIdentifier(string $scheme, string $identifier): self
    {
        return new self(sprintf('%s%s%s', $scheme, self::SPLIT_IDENTIFIER, $identifier));
    }

    public function getScheme(): string
    {
        return $this->split()['scheme'];
    }

    public function getIdentifier(): string
    {
        return $this->split()['identifier'];
    }

    #[ArrayShape(['scheme' => "string", 'identifier' => "string"])]
    private function split(): array
    {
        [$scheme, $identifier] = explode(self::SPLIT_IDENTIFIER, $this->identifier);
        return [
            'scheme' => $scheme,
            'identifier' => $identifier,
        ];
    }

    public function __toString(): string
    {
        return $this->identifier;
    }
}
