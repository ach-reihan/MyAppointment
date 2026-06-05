<?php

namespace App\Models;

use Database\Factories\ClinicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @use HasFactory<ClinicFactory> */
class Clinic extends Model
{
    use HasFactory;

    protected $guarded = [];
}
