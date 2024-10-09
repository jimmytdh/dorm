<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'assignment_id',
        'amount',
        'status',
        'process_by',
        'remarks',
    ];

    public function bedAssignment() {
        return $this->belongsTo(BedAssignment::class,'assignment_id');
    }

    public function processBy() {
        return $this->belongsTo(User::class,'process_by');
    }
}
