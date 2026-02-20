<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'criteria_id',
        'number_rating',
        'remarks'
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
