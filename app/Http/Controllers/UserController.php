<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
       /**
    * @OA\Get(
    *     path="/api/users",
    *     summary="Show paginated users by 5",
    *     @OA\Response(
    *         response=200,
    *         description="show all users paginated by 5."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Something went wrong!"
    *     )
    * )
    */
    public function getUsers() {

        try {

            return response()->json([
                'status' => true,
                'data' => User::paginate(5)
            ]);

        }catch(\Exception $e){

            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong!'
            ], 500);
        }
        
    }

    public function store(UserRequest $request) {

        try {
            
            $input = $request->only('email', 'first_name', 'password');

            $user = User::create([
                'email' => $input['email'],
                'first_name' => $input['first_name'],
                'password' => Hash::make($input['password']),
            ]);

            return response()->json([
                'status' => true,
                'msg' => 'User created successfully!',
                'data' => $user
            ]);

        }catch(\Exception $e){

            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong!'
            ], 500);
        }
        
    }

    public function update($id, UserRequest $request) {

        try{

            $input = $request->only('email', 'first_name', 'password');

            $user = User::findOrFail($id);
            
            $user->email = $input['email'];
            $user->first_name = $input['first_name'];
            $user->password = Hash::make($input['password']);

            $user->save();

            return response()->json([
                'status' => true,
                'msg' => 'User updated successfully!',
                'data' => $user
            ]);

        }catch(\Exception $e) {

            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong!',
                'e' => $e->getMessage()
            ], 500);
        }
    }
}
