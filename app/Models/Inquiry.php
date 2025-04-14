<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $table = 'inquiry';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact',
        'unit_type',
        'message',
        'agree_to_privacy'
    ];
}
