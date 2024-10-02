<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'amount',
        'status',
        'process_by',
        'remarks',
    ];

    public function bedAssignment() {
        return $this->belongsTo(BedAssignment::class);
    }

    public function processBy() {
        return $this->belongsTo(User::class);
    }
}
