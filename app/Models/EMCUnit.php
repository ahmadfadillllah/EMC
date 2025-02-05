<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EMCUnit extends Model
{
    //
    protected $table = 'emc_unit';
    protected $primaryKey = 'id_unit';

    protected $guarded = [];

    public $timestamps = false;
}
