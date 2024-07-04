<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\ResponseHelper;
use App\Http\Controllers\ApiController;
use App\Http\Resources\ReportFileResource;
use App\Jobs\ReportAllGame;
use App\Models\ReportFile;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReportController extends ApiController
{
    public function store()
    {
        $report = ReportFile::init();
        $report->save();
        dispatch(new ReportAllGame($report->uuid));
        return ResponseHelper::success('ok', new ReportFileResource($report));
    }

    public function show($uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw new BadRequestHttpException();
        }
        $report = ReportFile::query()->where('uuid', $uuid)->first();
        return ResponseHelper::success('ok', new ReportFileResource($report));
    }

}