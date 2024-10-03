<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Program extends Model
{
    use HasFactory;

    // protected static function booted(): void
    // {
    //     static::created(function (Program $program) {
    //         Target_program::create([
    //             'program_id' => $program->id,
    //             'indikator' => 'belum ditentukan',
    //             'kinerja' => 0,
    //         ]);
    //     });
    // }

    public function target_programs(): HasMany
    {
        return $this->hasMany(Target_program::class);
    }
    
    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function subkegiatans(): HasManyThrough
    {
        return $this->hasManyThrough(Subkegiatan::class, Kegiatan::class);
    }
}
