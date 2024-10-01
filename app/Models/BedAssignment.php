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
        'occupation_type',
        'process_by',
        'check_in',
        'check_out',
    ];
}
