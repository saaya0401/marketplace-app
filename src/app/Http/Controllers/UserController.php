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
        return redirect('/mypage/profile');
    }

    public function profile(){
        $user=Auth::user();
        $profile=Profile::where('user_id', $user->id)->firstOrNew();
        return view('profile', compact('user', 'profile'));
    }

    public function profileStore(ProfileRequest $request){
        $profile=$request->only(['profile_image', 'postal_code', 'address', 'building']);
        $profile['user_id']=Auth::id();
        Profile::create($profile);
        return redirect('/');
    }

    public function profileUpdate(ProfileRequest $request){
        $profile=$request->only(['profile_image', 'postal_code', 'address', 'building']);
        $user_id=Auth::id();
        Profile::where('user_id', $user_id)->update($profile);
        return redirect('/mypage');
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

    public function addressUpdate(AddressRequest $request, $itemId){
        $item=Item::find($itemId);
        $profile=$request->only(['user_id', 'postal_code', 'address', 'building']);
        Profile::where('user_id', Auth::id())->update($profile);
        return redirect('/purchase/' . $itemId);
    }
}
