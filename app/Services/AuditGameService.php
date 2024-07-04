<?php

namespace App\Services;

use App\Helper\CacheHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuditGameService
{

    const CERTAIN_TOO_MUCH_GAME = 10;
    const CERTAIN_CHEAT_IP = 5;

    public function handle(): void
    {
        $timeCheck = date('Y-m-d H:i:s', strtotime('-1 hour'));

        ####
        # Kiểm tra xem có ai chỉ tạo game liên tục mà không chơi
        ####

        # dùng query builder để laravel không cần hydrate model
        $ids = DB::table('games')
            ->where('created_at', '>', $timeCheck)
            ->whereNull('finished_at') // chưa hoàn thành game
            ->selectRaw('user_id, COUNT(id) as total_game_not_finish')
            ->groupBy('user_id')
            ->having('total_game_not_finish', '>' , static::CERTAIN_TOO_MUCH_GAME)
            ->get()
            ->pluck('user_id')
        ;
        $this->_storeBlackList($ids);

        ####
        # Kiểm tra xem có user chơi hoàn thành, mà login quá nhiều ip (clone nhiều acc chơi gom quà)
        ####

        # dùng query builder để laravel không cần hydrate model
        $ids = DB::table('games')
            ->where('created_at', '>', $timeCheck)
            ->whereNotNull('finished_at') // user hoàn thành game
            ->selectRaw('user_id, COUNT(ip) as total_ip')
            ->groupBy('user_id')
            ->having('total_ip', '>' , static::CERTAIN_CHEAT_IP)
            ->get()
            ->pluck('user_id')
        ;
        $this->_storeBlackList($ids);
    }

    private function _storeBlackList($ids): void
    {
        $blackListIds = (array) Cache::get(CacheHelper::USER_BLACKLIST);

        foreach ($ids as $id) {
            if (!in_array($id, $blackListIds)) {
                $blackListIds[] = $id;
            }
        }

        #lưu vào redis để api đỡ phải query db
        Cache::rememberForever(CacheHelper::USER_BLACKLIST, fn() => $blackListIds);
    }
}