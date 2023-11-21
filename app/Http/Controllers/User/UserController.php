<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Squad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Update user profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $rules = [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'city_id' => 'nullable|exists:iran_cities,id',
            'create_squad' => 'required|boolean',
        ];

        if($request->create_squad) {
            $rules = array_push($rules, [
                'squad.name' => 'required_if:create_squad,true|max:255',
                'squad.members' => 'required_if:create_squad,true|array|min:1|max:5',
                'squad.members.*.firstname' => 'required_if:create_squad,true|max:255',
                'squad.members.*.lastname' => 'required_if:create_squad,true|max:255',
                'squad.members.*.phone' => 'required_if:create_squad,true|max:255|distinct|phone:IR,mobile|unique:users,phone',
            ]);
        }

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $user = tap(auth()->user())->update($data);
        if($request->create_squad) {
            $squad = Squad::create(['name' => $data['squad']['name']]);
            $squad->members()->attach($user, ['role' => 'owner']);
            foreach($data['squad']['members'] as $member) {
                $squad->members()->create($member);
            }
        }

        $user = new UserResource($user);
        $message = __('user.messages.profile_updated');
        return response()->json(compact('user', 'message'), 201);
    }
}
