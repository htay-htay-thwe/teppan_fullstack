<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserDataController extends Controller
{
    public function userData(Request $request){
        $data = $this->getUserData($request);
        $userData= User::create($data);
        $userData = User::where('tableNumber',$request->tableNumber)->first();
        return response()->json([
           'status' => 'success',
           'userData' => $userData,
           'token' =>$userData->createToken(time())->plainTextToken,
         ]);
    }

    public function login(Request $request){
        $userData = User::where('tableNumber',$request->tableNumber)->first();
        if(isset($userData)){
            if(Hash::check($request->password,$userData->password)){
                return response()->json([
                    'status' => 'success',
                    'userData' => $userData,
                    'token' =>$userData->createToken(time())->plainTextToken,
                  ]);
                }else{
                    return response()->json([
                        'user' => null,
                        'token' =>null,
                    ]);
                };
            }else{
                return response()->json([
                    'user' => null,
                    'token' =>null,
                ]);
            };
        }


    private function getUserData($request){
        return[
            'tableNumber'=> $request->tableNumber,
            'password' => Hash::make($request->password),
        ];
    }

}
