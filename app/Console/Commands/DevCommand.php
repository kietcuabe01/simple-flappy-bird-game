<?php

namespace App\Console\Commands;

use App\Helper\CacheHelper;
use App\Http\Resources\ReportFileResource;
use App\Jobs\ReportAllGame;
use App\Models\Game;
use App\Models\ReportFile;
use App\Models\Reward;
use App\Models\User;
use App\Services\AuditGameService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Lottery;
use Ramsey\Uuid\Uuid;

class DevCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dev';

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
//        User::insert([
//            ['phone' => '0359753662', 'name' => '', 'email' => null],
//            ['phone' => '0359753663', 'name' => 'Kiet', 'email' => 'tranquockiet.cs@gmail.com'],
//        ]);
//
//        Game::insert([
//            ['user_id' => 1, 'reward_id' => null, 'score' => 5, 'finished_at' => '2024-07-01 17:44:56', 'created_at' => date('now')],
//            ['user_id' => 1, 'reward_id' => null, 'score' => 4, 'finished_at' => null, 'created_at' => date('now')],
//            ['user_id' => 2, 'reward_id' => null, 'score' => 2, 'finished_at' => null, 'created_at' => date('now')],
//            ['user_id' => 2, 'reward_id' => 1, 'score' => 5, 'finished_at' => '2024-05-02 09:55:56', 'created_at' => date('now')],
//            ['user_id' => 2, 'reward_id' => null, 'score' => 1, 'finished_at' => null, 'created_at' => date('now')],
//            ['user_id' => 1, 'reward_id' => null, 'score' => 4, 'finished_at' => null, 'created_at' => date('now')],
//        ]);

//        $report = ReportFile::init();
//        $report->save();
//        echo $report->uuid, PHP_EOL;
//        dispatch(new ReportAllGame($report->uuid));
//        $uuid = '484e3b6b-720e-40e2-9f79-447f8cb360df';
//        echo ((new ReportFileResource(ReportFile::query()->where('uuid', $uuid)->first()))->toJson()), PHP_EOL;

        app(AuditGameService::class)->handle();

        dump(Cache::get(CacheHelper::USER_BLACKLIST));
    }
}
