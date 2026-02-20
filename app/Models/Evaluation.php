<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name',
        'po_no',
        'date_evaluation',
        'covered_period',
        'office_name'
    ];

    // Relation to criteria scores
    public function criteriaScores()
    {
        return $this->hasMany(CriteriaScore::class);
    }

    // Relation to digital approvals
    public function digitalApprovals()
    {
        return $this->hasMany(DigitalApproval::class);
    }

    // Optional: relation to overall rating if you need it
    public function overallRating()
    {
        return $this->hasOne(OverallRating::class);
    }
}
