<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function register(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required | email',
            'password' => 'required',
            'c_password' => 'required | same:password'
        ]);
        if ($validator->fails()){
            return $this->sendError('Validator Error.',$validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $succes['token'] = $user->createToken('users')->plainTextToken;
        $succes['name'] = $user->name;

        return $this->sendResponse($succes,'User Register Successfully.');

    }


    public function login(Request $request):JsonResponse
    {
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = \auth()->user();
            $success['token'] = $user->createToken('users')->plainTextToken;
            $success['name'] = $user->name;

            return  $this->sendResponse($success,'User LoginSuccessfully.');
        }
        return $this->sendError('Unauthorised',['error'=>'Unauthorised']);
    }
}
