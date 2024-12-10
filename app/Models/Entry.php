<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Entry extends Model
{
    /** @use HasFactory<\Database\Factories\EntryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'user_id',
    ];

    public function user(): HasOne {
        return $this->hasOne(User::class);
    }

    public function energyLevel(): int {
        switch ($this->type) {
            case 'cola':
                return 1;
            case 'coke':
                return 1;
            default:
                return 3;
        }
    }
}
