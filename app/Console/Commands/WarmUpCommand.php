<?php

namespace App\Console\Commands;

use App\Helper\UserAgentHelper;
use App\Models\Reward;
use Illuminate\Console\Command;

class WarmUpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:warm-up';

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
        // prepare data to cache
        Reward::getAllRewards();

        #warm up vì laravel octane lần đầu nhận request sẽ chậm
        $url = 'http://127.0.0.1:8000/api/game';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);

        #$userAgent = app(UserAgentHelper::class);
    }
}
