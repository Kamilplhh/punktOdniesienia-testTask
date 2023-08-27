<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'title',
        'email',
        'paid',
        'price',
        'paymentDate',
        'bank',
        'nip',
        'invoice_number',
        'recipient',
        'adress',
        'content',
        'user_id',
    ];
}
