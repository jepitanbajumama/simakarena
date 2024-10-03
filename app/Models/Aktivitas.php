<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aktivitas extends Model
{
    use HasFactory;

    public function subkegiatan(): BelongsTo
    {
        return $this->belongsTo(Subkegiatan::class);
    }
}
