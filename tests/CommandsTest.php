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
        $this->oauth();

        $this->httpFake('/git/pull');

        $this->artisan('cw:deploy')
            ->assertExitCode(1);
    }

    /** @test */
    public function deploy_it_should_successfully()
    {
        $this->oauth();

        $this->httpFake('/git/pull', json_encode(['operation_id' => 123456]), 200);

        $this->artisan('cw:deploy', ['branch' => 'main', 'app' => 123456])
            ->expectsOutput('Deploy successfully!')
            ->expectsOutput('Operation ID: 123456')
            ->expectsOutput('Repository: git@test.git')
            ->expectsOutput('Branch: main')
            ->assertExitCode(0);
    }

    /** @test */
    public function app_backup_it_should_throw_an_exception()
    {
        $this->oauth();

        $this->httpFake('/app/manage/takeBackup');

        $this->artisan('cw:app-backup')
            ->assertExitCode(1);
    }

    /** @test */
    public function app_backup_it_should_successfully()
    {
        $this->oauth();

        $this->httpFake('/app/manage/takeBackup', json_encode(['operation_id' => 123456]), 200);

        $this->artisan('cw:app-backup')
            ->expectsOutput('App Backup successfully!')
            ->expectsOutput('Operation ID: 123456')
            ->assertExitCode(0);
    }
}
