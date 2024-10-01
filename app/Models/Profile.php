<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'fname',
        'lname',
        'sex',
        'dob',
        'contact',
        'address',
    ];

    public function bedAssignments()
    {
        return $this->hasMany(BedAssignment::class);
    }
}
