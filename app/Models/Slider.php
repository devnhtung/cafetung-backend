<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['title', 'description', 'background_image', 'button_link', 'button_text', 'is_active', 'order'];
}
