<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contractor;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'email',
        'file',
        'contractor',
        'address1',
        'address2',
        'bank',
        'nip',
        'description',
        'price',
        'paid',
        'type',
        'addDate',
        'cycleFrequency',
        'user_id',
        'contractor_id',
        'content'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

}
