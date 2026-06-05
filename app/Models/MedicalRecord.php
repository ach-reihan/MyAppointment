<?php

namespace App\Models;

use Database\Factories\MedicalRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @use HasFactory<MedicalRecordFactory> */
class MedicalRecord extends Model
{
    use HasFactory;

    protected $guarded = [];
}
