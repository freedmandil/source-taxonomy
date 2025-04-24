<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordSubTopic extends Model
{
    protected $table = 'keyword_sub_topic';

    protected $fillable = [
        'keyword_id',
        'sub_topic_id',
        'note',
    ];

    public function keyword()
    {
        return $this->belongsTo(Keyword::class);
    }

    public function subTopic()
    {
        return $this->belongsTo(SubTopic::class);
    }
}
