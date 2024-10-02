<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedAssignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'bed_id',
        'profile_id',
        'term',
        'process_by',
        'status',
        'check_in',
        'check_out',
        'remarks',
    ];

    public function bed() {
        return $this->belongsTo(Bed::class);
    }

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }
}
