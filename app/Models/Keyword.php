<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $fillable = ['slug', 'name_en', 'name_he', 'name_languages', 'note'];

    protected $casts = [
        'name_languages' => 'array',
    ];

    public function texts()
    {
        return $this->belongsToMany(Text::class)->withTimestamps()->withPivot('note');
    }

    public function subTopics()
    {
        return $this->belongsToMany(SubTopic::class)->withTimestamps()->withPivot('note');
    }
}
