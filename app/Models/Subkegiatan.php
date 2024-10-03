<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subkegiatan extends Model
{
    use HasFactory;

    // protected static function booted(): void
    // {
    //     static::created(function (Subkegiatan $subkegiatan) {
    //         Target_subkegiatan::create([
    //             'subkegiatan_id' => $subkegiatan->id,
    //             'kinerja' => 0,
    //             'anggaran' => 0,
    //         ]);
    //     });
    // }

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function target_subkegiatan(): HasOne
    {
        return $this->hasOne(Target_subkegiatan::class);
    }

    public function aktivitas(): HasMany
    {
        return $this->hasMany(Aktivitas::class);
    }
}
