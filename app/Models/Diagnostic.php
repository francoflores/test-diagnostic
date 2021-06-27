<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    use HasFactory;

    protected $fillable = ['diagnostic', 'diagnostic_date'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
