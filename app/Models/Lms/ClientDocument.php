<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDocument extends Model
{
    use HasFactory;
    protected $fillable=['doc_type', 'e_number', 'pax_name', 'doc_url',
        'created_by', 'updated_by'];
}
