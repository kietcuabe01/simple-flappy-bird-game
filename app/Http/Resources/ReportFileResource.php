<?php

namespace App\Http\Resources;

use App\Models\ReportFile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ReportFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ReportFile|JsonResource $this */
        return [
            'uuid' => $this->uuid,
            'path' => $this->path ? Storage::disk('public')->url($this->path) : '',
            'is_error' => (bool) $this->error
        ];
    }
}
