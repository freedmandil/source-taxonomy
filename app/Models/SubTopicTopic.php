<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTopicTopic extends Model
{
    protected $table = 'sub_topic_topic';

    protected $fillable = [
        'sub_topic_id',
        'topic_id',
    ];

    public function subTopic()
    {
        return $this->belongsTo(SubTopic::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
