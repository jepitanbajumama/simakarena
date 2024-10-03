<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kegiatan extends Model
{
    use HasFactory;

    // protected static function booted(): void
    // {
    //     static::created(function (Kegiatan $kegiatan) {
    //         Target_kegiatan::create([
    //             'kegiatan_id' => $kegiatan->id,
    //             'kinerja' => 0,
    //             'anggaran' => 0,
    //         ]);
    //     });
    // }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function target_kegiatan(): HasOne
    {
        return $this->hasOne(Target_kegiatan::class);
    }
 
    public function subkegiatans(): HasMany
    {
        return $this->hasMany(Subkegiatan::class);
    }
}
