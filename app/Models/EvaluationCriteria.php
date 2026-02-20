<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    // Table name (optional since it follows Laravel convention)
    protected $table = 'evaluation_criteria';

    // Mass assignable fields
    protected $fillable = [
        'criteria_name',
    ];

    /**
     * Relation to criteria scores
     */
    public function criteriaScores()
    {
        return $this->hasMany(CriteriaScore::class, 'criteria_id');
    }
}
