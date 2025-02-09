<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request){
        $validated=$request->validated();
        $validated['password']=Hash::make($validated['password']);
        $user=User::create($validated);
        Auth::login($user);
        return redirect('/profile');
    }

    public function profile(){
        $user=Auth::user();
        return view('profile', compact('user'));
    }

    public function profileStore(ProfileRequest $request){
        $profile=$request->only(['profile_image', 'postal_code', 'address', 'building']);
        $profile['user_id']=Auth::id();
        Profile::create($profile);
        return redirect('/');
    }

    public function login(LoginRequest $request){
        $credentials=$request->only('email', 'password');
        if(!Auth::attempt($credentials)){
            throw ValidationException::withMessages([
                'email'=>'ログイン情報が登録されていません'
            ]);
        }
        return redirect('/');
    }

    public function logout(){
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function address($itemId){
        $item=Item::find($itemId);
        return view('address', compact('item'));
    }

    public function addressChange(AddressRequest $request, $itemId){
        $item=Item::find($itemId);
        $profile=$request->only(['user_id', 'postal_code', 'address', 'building']);
        Profile::where('user_id', Auth::id())->update($profile);
        return redirect('/purchase/' . $itemId);
    }
}
