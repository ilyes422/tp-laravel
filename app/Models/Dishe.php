<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Dishe extends Model
{
    use HasFactory;

    public $casts = [
        'recette'=>'encrypted',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
