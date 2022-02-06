<?php

namespace Tests;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class CloudwaysTest extends TestCase
{
    /** @test */
    public function start_git_pull_should_throw_an_exception()
    {
        $cloudways = app('cloudways');

        Http::fake([config('cloudways.base_url') . '*' => Http::response(null, 500)]);

        $this->expectException(RequestException::class);

        $cloudways->startGitPull(1000, 2000, 'git_url', 'develop');
    }
}
