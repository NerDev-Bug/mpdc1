<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'table_booking';

    protected $fillable = [
        'first_name', // Updated from 'name' to 'first_name'
        'last_name',  // Added 'last_name'
        'email',
        'contact_number',
        'date',
        'time',
    ];
}
