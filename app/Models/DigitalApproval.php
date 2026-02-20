<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalApproval extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel naming convention)
    protected $table = 'digital_approvals';

    // Mass assignable fields
    protected $fillable = [
        'evaluation_id',
        'full_name',
        'designation',
        'role',
        'image',
    ];

    /**
     * Get the evaluation associated with this digital approval.
     */
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
