<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;
class CertificateType extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'certificate_types';
    protected $fillable = array('preview', 'name', 'grade', 'score', 'expiry_date', 'tutor');
    }