<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ahp extends Model
{
    protected $table = 'ahp_bobots';

    protected $fillable = [
        'kriteria_id',
        'bobot',
        'matrix_json',
    ];

    protected $casts = [
        'bobot' => 'float',
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
