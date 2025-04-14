<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $fillable = [
        'inquiry_type',
        'first_name',
        'last_name',
        'email',
        'country_code',
        'mobile',
        'project',
        'description',
        'agree_terms',
    ];
}
