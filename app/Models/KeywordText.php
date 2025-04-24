<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordText extends Model
{
    protected $table = 'keyword_text';

    protected $fillable = [
        'keyword_id',
        'text_id',
        'note',
    ];

    public function keyword()
    {
        return $this->belongsTo(Keyword::class);
    }

    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}
