<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @property string title
 * @property string status
 * @property string status_color
 * @property \DateTime date
 * @property string date_for_humans
 * @property string date_for_editing
 *
 * @package App\Models
 */
class Transaction extends Model
{
    use HasFactory;

    public const STATUS = [
        'success' => 'Success',
        'processing' => 'Processing',
        'failed' => 'Failed',
    ];

    protected $guarded = [];
    protected $appends = ['date_for_editing'];
    protected $casts = ['date' => 'date'];

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

    /**
     * @return ?string
     */
    public function getDateForEditingAttribute(): ?string
    {
        return optional($this->date)->format('Y-m-d');
    }
    /**
     * @param $value
     */
    public function setDateForEditingAttribute($value) : void
    {
        $this->date = Carbon::parse($value);
    }
}
