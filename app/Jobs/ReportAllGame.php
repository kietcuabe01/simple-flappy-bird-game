<?php

namespace App\Jobs;

use App\Exports\GameExport;
use App\Models\ReportFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\UuidInterface;

class ReportAllGame implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var UuidInterface
     */
    protected $uuid;

    /**
     * Create a new job instance.
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = sprintf(
            'reports/games/%s/%s.xlsx',
            date('Y/m/d'),
            $this->uuid->toString()
        );
        $error = '';
        $exception = null;
        try {
            Excel::store(new GameExport(), $path, 'public');
        } catch (\Throwable $throwable) {
            $error = $throwable->getTraceAsString();
            $exception = $throwable;
        }

        /** @var ReportFile $reportFile */
        $reportFile = ReportFile::query()->where('uuid', $this->uuid)->first();
        $reportFile->path = $path;
        $reportFile->error = $error;
        $reportFile->save();

        if ($exception) {
            throw $exception; //Ném ra để framework xử lí như retry hoặc log vào db
        }
    }
}
