<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ExpirationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::where('expired','=',0)->update(['expired'=>1]);
    }
}
