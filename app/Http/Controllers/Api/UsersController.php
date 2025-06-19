<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UsersResources;
use App\Http\Requests\GlobalRequest;
use App\Models\Users;
use App\Helpers\ApiResponse;
use App\Http\Resources\usersCollection;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\UsersValidationRequest;
use App\Http\Requests\UsersValidationRequestUpdate;

class UsersController extends Controller
{
     protected $Users;
    public function __construct(Users $Users) {
        $this->Users = $Users;
    }
     

    public function index(GlobalRequest $request)
    {
        
        $validated = $request->validated();

        $search = $validated['search'] ?? null;
        $perPage = is_numeric($validated['per_page'] ?? null) ? $validated['per_page'] : 10;
        $sortBy = $validated['sort_by'] ?? 'created_at';
        $sortDir = $validated['sort_dir'] ?? 'desc';
        // $onlyDeleted = $validated['only_deleted'] ?? false;


        $query = $this->Users
            // ->onlyDeleted($onlyDeleted)
            ->search($search)
            ->sort($sortBy, $sortDir);

        $results = $query->paginate($perPage);

        //cara kurang simple
        // if ($results->isEmpty()) {
        //     return ApiResponse::success([], "Data yang Anda cari tidak ditemukan");
        // }
         //cara simple
        $message = $results->isEmpty() ? "Data yang Anda cari tidak ditemukan" : "Success";

        // return ApiResponse::paginate(new usersCollection($results));
        return ApiResponse::paginate(new usersCollection($results), $message);

    }

    public function show(string $id)
        {

            $user = $this->Users->find($id);

            if (!$user) {
                return ApiResponse::error('User not found', [
                    'id' => ['Data dengan ID tersebut tidak tersedia']
                ], 404);
                
            }

            return ApiResponse::success(new UsersResources($user), 'Success get user detail', 200);
            
        }



    // public function store(UsersValidationRequest $request)
    // {
    //     $data = $request->validated();

    //     $errors = Users::isDuplicate($data); 
    //     if (!empty($errors)) {
    //         throw new HttpResponseException(response()->json([
    //             'errors' => $errors
    //         ], 400));
    //     }

    //     $user = $this->Users->create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
        
    //     ]);

    //     return ApiResponse::success(new UsersResources($user), 'Success Create New User', 201);
    // }

    public function store(UsersValidationRequest $request)
{
    $data = $request->validated();

    try {
        // Optional: cek duplikasi manual (jika memang ingin override validasi laravel)
        $errors = Users::isDuplicate($data); 
        if (!empty($errors)) {
            throw new HttpResponseException(response()->json([
                'errors' => $errors
            ], 400));
        }

        $user = $this->Users->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            // 'password' => bcrypt($data['password']), // pastikan hash password
            // 'role'     => $data['role'] ?? 'user'     // default role jika ada
        ]);

        return ApiResponse::success(new UsersResources($user), 'Success Create New User', 201);

    } catch (\Illuminate\Database\QueryException $e) {
        // Untuk menangkap error SQL seperti duplicate email
        return ApiResponse::error('Gagal membuat user (query error)', [
            'exception' => config('app.debug') ? $e->getMessage() : null
        ], 422);
    } catch (\Exception $e) {
        // General error fallback
        return ApiResponse::error('Terjadi kesalahan saat membuat user', [
            'exception' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}



//     public function update(UsersValidationRequestUpdate $request, $id)
// {
//     $data = $request->validated();

//     $UserData = $this->Users->find($id);

//     if (!$UserData) {
//         return ApiResponse::error('User dengan ID tersebut tidak ditemukan', [], 404);
//     }

//     try {
//         $UserData->update($data);
//         return ApiResponse::success(new UsersResources($UserData), 'Success Update New User', 200);
//     } catch (\Exception $e) {
//         return ApiResponse::error('Failed to update User', [
//             'exception' => config('app.debug') ? $e->getMessage() : 'Please try again later'
//         ], 500);
//     }
// }

public function update(UsersValidationRequestUpdate $request, $id)
{
    $data = $request->validated();

    $user = $this->Users->find($id);

    if (!$user) {
        return ApiResponse::error('User dengan ID tersebut tidak ditemukan', [], 404);
    }

    try {
        // Hash password jika dikirim
        // if (isset($data['password'])) {
        //     $data['password'] = bcrypt($data['password']);
        // } else {
        //     unset($data['password']);
        // }

        $user->update($data);

        return ApiResponse::success(new UsersResources($user), 'Success Update User', 200);
    } catch (\Illuminate\Database\QueryException $e) {
        return ApiResponse::error('Gagal update user (query error)', [
            'exception' => config('app.debug') ? $e->getMessage() : null
        ], 422);
    } catch (\Exception $e) {
        return ApiResponse::error('Failed to update User', [
            'exception' => config('app.debug') ? $e->getMessage() : 'Please try again later'
        ], 500);
    }
}


public function destroy(string $id)
{
    try {
        $user = $this->Users->find($id);

        if (!$user) {
            return ApiResponse::error('User dengan ID tersebut tidak ditemukan', [], 404);
        }

        $user->delete();

        return ApiResponse::success(new UsersResources($user), 'Success Delete User', 200);
    } catch (\Exception $e) {
        return ApiResponse::error('Failed to delete user', [
            'exception' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}



}
