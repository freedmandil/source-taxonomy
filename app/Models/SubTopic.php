<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTopic extends Model
{
    protected $fillable = ['slug', 'name_en', 'name_he', 'name_languages', 'note'];

    protected $casts = [
        'name_languages' => 'array',
    ];

    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps()->withPivot('note');
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class)->withTimestamps()->withPivot('note');
    }
}
