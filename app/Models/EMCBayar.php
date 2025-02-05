<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EMCBayar extends Model
{
    //
    protected $table = 'emc_bayar';

    protected $primaryKey = 'id_bayar';

    protected $guarded = [];

    public $timestamps = false;
}
