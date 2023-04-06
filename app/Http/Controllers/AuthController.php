<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Component\HttpFoundation\Response;
class AuthController extends Controller
{
    public function login(Request $request ){
        $validator =Validator::make($request->all(),[
        'email'=>['required','string','email','max:255'],

            'password'=>['required','string','min:8'],

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->all(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $credentials =request(['email','password']);
        if(!Auth::attempt($credentials)){
            throw new AuthenticationException();
        }
        $user =$request->user();

        //add token to user
        $tokenResult =$user->createToken('Personal Access Token');

        $data["user"] = $user;
        $data["token_type"] = 'Bearer';
        $data["access_token"] = $tokenResult->accessToken;
        return response()->json($data,Response::HTTP_OK);
    }


    public function createAccount(Request $request ){

        $validator =Validator::make($request->all(),[
            'name'=>['required','string','max:255'],
            'age'=>['required','numeric'],
            'email'=>['required','string','email','max:255',Rule::unique('users')],

            'password'=>['required','string','min:8'],
            ]);
        if($validator->fails()){
            return$validator->errors()->all();
        }
        $request['password']=Hash::make($request['password']);
        $user =User::query()->create([
            'name'=>$request->name,
                'age'=>$request->age,
                'email'=>$request->email,
                'password'=>$request->password,
                 'phone'=>$request->phone,
            'address'=>$request->address,
            'profile_img_url'=>$request->profile_img_url,
            'whatsapp_url'=>$request->whatsapp_url,
            'facebook_ing_url'=>$request->facebook_ing_url,
            ]);
       //add token to user
        $tokenResult =$user->createToken('Personal Access Token');
        $data["user"] =$user;
        $data["token_type"] = 'Bearer';
        $data["access_token"] =$tokenResult->accessToken;
        return response()->json($data,Response::HTTP_OK);
    }



}
