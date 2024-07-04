<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * @property $uuid
 * @property $path
 * @property $error
 */
class ReportFile extends Model
{
    protected $table = 'report_files';

    protected $fillable = [
        'uuid',
        'path',
        'error'
    ];

    public static function init(): ReportFile
    {
        $uuid = Uuid::uuid4();
        return new ReportFile(['uuid' => $uuid]);
    }
}