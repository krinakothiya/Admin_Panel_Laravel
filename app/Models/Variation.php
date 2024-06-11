<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;
    protected $table = 'variations';                          // specify the table name if different from the default
    protected $primaryKey = 'var_id';
}
