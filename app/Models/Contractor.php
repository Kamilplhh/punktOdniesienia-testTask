<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor',
        'address1',
        'address2',
        'bank',
        'nip',
        'email',
        'user_id',
    ];
}
