<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $fillable = ['sefer_id', 'note'];

    public function sefer()
    {
        return $this->belongsTo(Sefer::class);
    }

    public function references()
    {
        return $this->hasMany(TextReference::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps()->withPivot('note');
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class)->withTimestamps()->withPivot('note');
    }
}
