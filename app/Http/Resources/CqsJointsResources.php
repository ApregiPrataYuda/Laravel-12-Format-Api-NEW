<?php

// namespace App\Http\Resources;

// use Illuminate\Http\Request;
// use Illuminate\Http\Resources\Json\JsonResource;

// class CqsJointsResources extends JsonResource
// {
//     /**
//      * Transform the resource into an array.
//      *
//      * @return array<string, mixed>
//      */
//     public function toArray(Request $request): array
//     {
//         return [
//             'id' => $this->id,
//             'weldmap_id' => $this->weldmap_id,
//             'joint_no' => $this->joint_no,
//             'weld_length' => $this->weld_length,
//             'piecemark_a' => $this->piecemark_a,
//             'piecemark_b' => $this->piecemark_b,
//             'position' => $this->position,
//             'ndt_req' => $this->ndt_req,
//             'pwht' => $this->pwht,
//             'material_group' => $this->material_group,
//             'joint_type' => $this->joint_type,
//             'weld_type' => $this->weld_type,
//             'is_used' => $this->is_used,
//             'is_dimensional' => $this->is_dimensional,
//             'sheet' => $this->sheet,
//             'remarks' => $this->remarks,
//             'ndt_percentage' => $this->ndt_percentage,
//             'size' => $this->size,
//             'welding_process' => $this->welding_process,
//             'created_at' => $this->created_at?->toDateString() ?? '-',
//             'updated_at' => $this->updated_at?->toDateString() ?? '-',
//         ];
//     }
// }


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CqsJointsResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'weldmap_id' => $this->weldmap_id,
            'joint_no' => $this->joint_no,
            'weld_length' => $this->weld_length,
            'piecemark_a' => $this->piecemark_a,
            'piecemark_b' => $this->piecemark_b,
            'position' => $this->position,
            'ndt_req' => $this->ndt_req,
            'pwht' => $this->pwht,
            'material_group' => $this->material_group,
            'joint_type' => $this->joint_type,
            'weld_type' => $this->weld_type,
            'is_used' => $this->is_used,
            'is_dimensional' => $this->is_dimensional,
            'sheet' => $this->sheet,
            'remarks' => $this->remarks,
            'ndt_percentage' => $this->ndt_percentage,
            'size' => $this->size,
            'welding_process' => $this->welding_process,
            'created_at' => $this->created_at?->toDateString() ?? '-',
            'updated_at' => $this->updated_at?->toDateString() ?? '-',
        ];
    }
}
