<?php

namespace App\Exports;

use App\Helper\DatetimeHelper;
use App\Models\Game;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GameExport implements FromQuery, WithMapping, WithHeadings
{
//    /**
//    * @return \Illuminate\Database\Query\Builder
//    */
    public function query()
    {
        return Game::with(['user'])->orderBy('id');
    }

    public function map($row): array
    {
        /** @var Game $row */
        return [
            $row->user->phone,
            $row->user->name,
            $row->user->email,
            $row->score,
            $row->reward_name,
            $row->created_at ? $row->created_at->format(DatetimeHelper::FORMAT_DATETIME) : '',
            $row->finished_at ? $row->finished_at->format(DatetimeHelper::FORMAT_DATETIME) : ''
        ];
    }

    public function headings(): array
    {
        return ['User - Phone', 'User - Name', 'User - Email', 'Game - Score', 'Game - Reward', 'Game - Begin At', 'Game - Finished At'];
    }

}
