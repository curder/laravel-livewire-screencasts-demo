<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @property string status
 * @property string status_color
 * @property \DateTime date
 *
 * @package App\Models
 */
class Transaction extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * @return string
     */
    public function getStatusColorAttribute() : string
    {
        return [
            'success' => 'green',
            'failed' => 'red',
        ][$this->status] ?? 'cool-gray';
    }

    /**
     * @return string
     */
    public function getDateForHumansAttribute(): string
    {
        return $this->date->format('M, d Y');
    }
}
