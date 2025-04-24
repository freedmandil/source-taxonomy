<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = ['name_english', 'name_hebrew', 'name_languages', 'meta', 'note'];

    protected $casts = [
        'name_languages' => 'array',
        'meta' => 'array',
    ];

    public function sefarim()
    {
        return $this->hasMany(Sefer::class);
    }
}
