<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Model
{
    use HasFactory;  use HasApiTokens, HasFactory, Notifiable;
    // SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];
    


    //opsional
    // public function scopeOnlyDeleted(Builder $query, bool $only = false): Builder
    // {
    //     return $only ? $query->onlyTrashed() : $query;
    // }


//     public function scopeSearch($query, $term)
// {
//     if (!empty($term)) {
//         $query->where('name', 'like', '%' . $term . '%');
//     }
//     return $query;
// }

public function scopeSearch($query, $term)
{
    if (!empty($term)) {
        $query->where(function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%')
              ->orWhere('email', 'like', '%' . $term . '%');
        });
    }
    return $query;
}


// Scope untuk sorting dinamis
public function scopeSort($query, $sortBy, $sortDir)
{
    return $query->orderBy($sortBy ?? 'created_at', $sortDir ?? 'asc');
}


// public static function isDuplicate(array $data): array
// {
//     $errors = [];

//     // Misalnya: validasi tambahan kalau nama dan email sama persis, tidak boleh
//     if (static::where('name', $data['name'])
//         ->where('email', $data['email'])
//         ->exists()) {
//         $errors['name_email'] = ['Kombinasi nama dan email sudah digunakan.'];
//     }

//     return $errors;
// }

public static function isDuplicate(array $data): array
{
    $errors = [];

    if (static::where('name', $data['name'])->exists()) {
        $errors['name'] = ['Nama user sudah digunakan.'];
    }

    if (static::where('email', $data['email'])->exists()) {
        $errors['email'] = ['Email sudah digunakan.'];
    }

    if (static::where('name', $data['name'])
        ->where('email', $data['email'])
        ->exists()) {
        $errors['name_email'] = ['Kombinasi nama dan email sudah digunakan.'];
    }

    return $errors;
}


}
