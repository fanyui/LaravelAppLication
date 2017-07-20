<?php

namespace App;

use App\Events\FileUploadedEvent;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
    protected $fillable = [
        'email', 'image'
    ];


    protected $events = [
        'saved' => FileUploadedEvent::class,
        'created' => FileUploadedEvent::class,
    ];
}
