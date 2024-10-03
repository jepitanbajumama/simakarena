<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Renja extends Model
{
    use HasFactory;
    protected $table = 'programs';

    public function target_program(): HasOne
    {
        return $this->hasOne(Target_program::class);
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
