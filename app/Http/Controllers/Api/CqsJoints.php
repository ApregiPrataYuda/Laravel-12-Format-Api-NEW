<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CqsModelJoints;
use App\Helpers\ApiResponse;
use App\Http\Requests\CqsJointsRequest;
use App\Http\Resources\CqsJointsResources;
use App\Http\Resources\CqsJointsCollection;


class CqsJoints extends Controller
{
    protected $CqsModelJoints;
    public function __construct(CqsModelJoints $CqsModelJoints) {
        $this->CqsModelJoints = $CqsModelJoints;
    }

    // public function index(CqsJointsRequest $request) {
    //     $validated = $request->validated();

    //     $search      = $validated['search'] ?? null;
    //     $perPage     = $validated['per_page'] ?? 10;
    //     $sortBy      = $validated['sort_by'] ?? 'created_at';
    //     $sortDir     = $validated['sort_dir'] ?? 'desc';
     
    //     $query = $this->CqsModelJoints
    //     ->search($search)
    //     ->sort($sortBy, $sortDir);
    
    //   $CqsJoints = $query->paginate($perPage);
    
        

    //     if ($CqsJoints->isEmpty()) {
    //         return ApiResponse::error('Data tidak ditemukan atau tidak tersedia', [
    //             'CqsJoints' => [],
    //             'pagination' => [
    //                 'total' => 0,
    //                 'per_page' => $perPage,
    //                 'current_page' => 1,
    //                 'last_page' => 1,
    //                 'next_page_url' => null,
    //                 'prev_page_url' => null,
    //             ]
    //         ], 404);
    //     }
    

    //     return ApiResponse::success('Success', [
    //         'CqsJoints' => CqsJointsResources::collection($CqsJoints),
    //         'pagination' => [
    //             'total' => $CqsJoints->total(),
    //             'per_page' => $CqsJoints->perPage(),
    //             'current_page' => $CqsJoints->currentPage(),
    //             'last_page' => $CqsJoints->lastPage(),
    //             'next_page_url' => $CqsJoints->nextPageUrl(),
    //             'prev_page_url' => $CqsJoints->previousPageUrl(),
    //         ]
    //     ]);
    // }

    public function index(CqsJointsRequest $request)
    {
        $validated = $request->validated();

        $search = $validated['search'] ?? null;
        $perPage = is_numeric($validated['per_page'] ?? null) ? $validated['per_page'] : 10;
        $sortBy = $validated['sort_by'] ?? 'created_at';
        $sortDir = $validated['sort_dir'] ?? 'desc';

        $query = $this->CqsModelJoints
            ->search($search)
            ->sort($sortBy, $sortDir);

        $results = $query->paginate($perPage);

        return ApiResponse::paginate(new CqsJointsCollection($results));
    }
}
