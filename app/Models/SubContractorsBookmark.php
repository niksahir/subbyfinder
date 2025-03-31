<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubContractorsBookmark extends Model
{
    use HasFactory;

    protected $table = "subcontractor_bookmarks";

    protected $fillable = ['user_id', 'subcontractor_id', 'type'];
}
