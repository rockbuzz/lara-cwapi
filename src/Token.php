<?php

declare(strict_types=1);

namespace Rockbuzz\LaraCwApi;

use Illuminate\Http\Client\RequestException;

class Token
{
    /** @var string */
    public $value;

    /** @var string */
    public $type;

    /** @var int */
    public $expires;

    public function __construct(string $value, string $type, int $expires)
    {
        $this->value = $value;
        $this->type = $type;
        $this->expires = $expires;
    }

    /** @throws RequestException */
    public static function fromArray(array $params): Token
    {
        return new static(
            $params['access_token'],
            $params['token_type'],
            $params['expires_in']
        );
    }
}
