<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeveloperPrestation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, float>
     */
    protected $fillable = [
        'dev_id',
        'description',
        'prestation_id',
        'price',
        'created_at',
        'updated_at',
    ];

    public function prestation(): BelongsTo
    {
        return $this->belongsTo(Prestation::class);
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }
}