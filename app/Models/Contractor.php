<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;

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
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
