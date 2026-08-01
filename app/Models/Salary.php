<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'effective_date',
        'end_date',
        'is_current',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
