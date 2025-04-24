<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagText extends Model
{
    protected $table = 'tag_text';

    protected $fillable = [
        'tag_id',
        'text_id',
        'note',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}
