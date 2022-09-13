<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //
    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request){

        try{
            $validateUser=Validator::make($request->all(),[
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'password'=>'required'
            ]);
            if($validateUser->fails())
            {
                return response()->json([
                    'status'=>false,
                    'message'=>'validation error',
                    'errors'=>$validateUser->errors()],401
                );
            }

            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);

            return response()->json([
                'status'=>true,
                'message'=>'User Created Successfully',
                'token'=>$user->createToken('API Token')->plainTextToken
            ],200);

        }catch(throwable $th){
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ],500);
        }
    }

    public function loginUser(Request $request){
        try{
            $validateUser=Validator::make($request->all(),
            [
                'email'=>'required|email',
                'password'=>'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'validation error',
                    'error'=>$validateUser->error()
                ],401);

            }
            if(!Auth::attempt($request->only(['email','password']))){
                return response()->json([
                    'status'=>false,
                    'message'=>'Email and Possword is not correct'
                ],401);
            }
            $user=User::where('email',$request->email)->first();

            return response()->json([
                'status'=>true,
                'message'=>'Login Successful',
                'token'=>$user->createToken('API Token')->plainTextToken

            ],200);
            
        }catch(throwable $th){
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ],500);
        }
    }

}
