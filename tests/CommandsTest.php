<?php

namespace Tests;

use Illuminate\Support\Facades\Config;

class CommandsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('cloudways.server_id', 111);
        Config::set('cloudways.app_id', 222);
        Config::set('cloudways.git_url', 'git@test.git');
    }

    /** @test */
    public function deploy_it_should_throw_an_exception()
    {
        $this->httpFake('/git/pull');

        $this->artisan('cw:deploy')
            ->assertExitCode(1);
    }

    /** @test */
    public function app_backup_it_should_throw_an_exception()
    {
        $this->httpFake('/app/manage/takeBackup');

        $this->artisan('cw:app-backup')
            ->assertExitCode(1);
    }
}
