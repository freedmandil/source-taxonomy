<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $fillable = ['slug', 'name_en', 'name_he', 'name_languages', 'note'];

    protected $casts = [
        'name_languages' => 'array',
    ];

    public function references()
    {
        return $this->hasMany(TextReference::class);
    }
}
