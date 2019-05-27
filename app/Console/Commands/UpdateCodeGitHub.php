<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Request;

class UpdateCodeGitHub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateGithub:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update github code description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        //
    }
}
