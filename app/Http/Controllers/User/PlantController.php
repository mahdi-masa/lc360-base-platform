<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Plant;
use Illuminate\Support\Facades\Validator;
use App\Enum\PlantStageEnum;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Enum;

class PlantController extends Controller
{
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'stage' => ['required', new Enum(PlantStageEnum::class)],
            'area' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'required|string',
            'count' => 'required|numeric|min:1',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id();
        $plant = Plant::create($data);
        
        return response()->json([
            'plant' => $plant,
            'message' => __('plant.messages.created'),
        ], 201);
    }
}
