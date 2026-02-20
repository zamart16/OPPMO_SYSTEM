<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverallRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'overall_score'
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
