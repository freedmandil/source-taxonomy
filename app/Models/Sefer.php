<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sefer extends Model
{
    protected $table = 'sefarim';

    protected $fillable = ['hebrew_name', 'english_name', 'other_names', 'publisher_id', 'edition', 'publication_year'];

    protected $casts = [
        'other_names' => 'array',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function texts()
    {
        return $this->hasMany(Text::class);
    }
}
