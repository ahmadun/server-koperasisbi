<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'no_hp' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'nik' => $request->nik,
                'role' => $request->rule,
                'no_hp' => $request->no_hp,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role'=>$request->role
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), 
            [
                'no_hp' => 'required',
                'name' => 'required',
                'email' => 'required|email|',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }


           User::where('nik', $request->nik)
                ->update([
                    'password' => Hash::make($request->password)
                ]);

            return response()->json([
                'status' =>  true,
                'message' => 'User Updated Successfully'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateEmailNo(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'no_hp' => 'required',
                'email' => 'required',
                
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }


           User::where('nik', $request->nik)
                ->update([
                    'no_hp' => $request->no_hp,
                    'role' => $request->rule,
                    'email' => $request->email,
                ]);

            return response()->json([
                'status' =>  true,
                'message' => 'User Updated Successfully'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'nik' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }


            if(!Auth::attempt($request->only(['nik', 'password']))){
                return response()->json([
                    'isAuthenticated' => false,
                    'message' => 'Email & Password does not match with our record.',
                ]);
            }

            $user = User::where('nik', $request->nik)->first();

     

            return response()->json([
                'isAuthenticated' => true,
                'token_type' => 'Bearer',
                'nik' => $request->nik,
                'name' => $user->name,
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'role'=> $user->role
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged Out'], 200);
    }
}
