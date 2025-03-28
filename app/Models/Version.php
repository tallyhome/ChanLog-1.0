<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'version_number',
        'release_date',
        'description',
        'content',
        'image_path'
    ];
    
    protected $casts = [
        'release_date' => 'date',
    ];
}
