<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    protected $table = 'widgets';
    protected $fillable = ['admin_render_function','widget_area','widget_order','frontend_render_function','widget_name','widget_content'];
}
