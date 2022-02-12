<?php

namespace Tests;

use Illuminate\Http\Client\RequestException;

class CloudwaysTest extends TestCase
{
    protected $cloudways;

    public function setUp(): void
    {
        parent::setUp();

        $this->cloudways = app('cloudways');
    }

    /** @test */
    public function start_git_pull_should_throw_an_exception()
    {
        $this->httpFake('/git/pull');

        $this->expectException(RequestException::class);

        $this->cloudways->startGitPull(1000, 2000, 'git_url', 'develop');
    }

    /** @test */
    public function app_manage_backup_should_throw_an_exception()
    {
        $this->httpFake('/app/manage/takeBackup');

        $this->expectException(RequestException::class);

        $this->cloudways->appManageBackup(1000, 2000);
    }
}
