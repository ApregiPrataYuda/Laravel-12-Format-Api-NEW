<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CqsModelJoints extends Model
{
    use HasFactory;
    protected $table = 'cqs_joints';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
      

    // Scope untuk pencarian berdasarkan joint_no
public function scopeSearch($query, $term)
{
    if (!empty($term)) {
        $query->where('joint_no', 'like', $term . '%');
    }
    return $query;
}

// Scope untuk sorting dinamis
public function scopeSort($query, $sortBy, $sortDir)
{
    return $query->orderBy($sortBy ?? 'created_at', $sortDir ?? 'desc');
}
}
