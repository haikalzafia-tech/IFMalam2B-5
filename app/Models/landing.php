<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Landing extends Model
{
    // Pastikan ini 'landings', bukan 'landing_settings'
    protected $table = 'landings';

    protected $fillable = [
        'section_key',
        'title',
        'description',
        'image_content',
        'cta_text',
        'cta_link',
        'is_visible'
    ];
}
