<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextReference extends Model
{
    protected $table = 'text_references';

    protected $fillable = ['text_id', 'taxonomy_id', 'text_value', 'numeric_value', 'note'];

    public function text()
    {
        return $this->belongsTo(Text::class);
    }

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }
}
