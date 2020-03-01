<?php

namespace Bambamboole\LaravelCms\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'cms:install';

    protected $description = 'Publish all cms resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing cms assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'cms-assets']);

        $this->comment('Publishing cms Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'cms-config']);

        $this->info('Laravel cms was installed successfully.');
    }
}
