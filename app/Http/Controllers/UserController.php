<?php

namespace App\Http\Controllers;

use App\Events\FollowNotify;
use App\Http\Requests\EditUserProfileValidate;
use App\Http\Requests\LoginRequestValidate;
use App\Http\Requests\RegisterRequestValidate;
use App\Http\Requests\ResetPasswordRequestValidate;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }

    public function register(RegisterRequestValidate $request)
    {
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request->validated());
        Auth::login($user);

        return redirect('/');
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function login(LoginRequestValidate $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        return view('account.userInfo', compact('user'));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        return view('account.edit', compact('user'));
    }

    public function update($id, EditUserProfileValidate $request)
    {
        $user = User::findOrFail($id);
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
    
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = 'storage/' . $avatarPath;
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect()->route('user.show', Auth::id())->with('success', 'Profile updated successfully!');
    }

    public function editPassword($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        return view('account.editPassword', compact('user'));
    }

    public function updatePassword($id, ResetPasswordRequestValidate $request)
    {
        $user = User::findOrFail($id);
        
        if (!Hash::check($request->old_password, $user->password))
        {
            return redirect()->back()->with('error', 'Wrong old password!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.show', $id)->with('success', 'Password reset successfully!');
    }

    public function follow($id)
    {
        $user = User::findOrFail($id);
        $authUser = Auth::user();
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You can not follow yourself!');
        }

        $result = $authUser->followings()->toggle($user->id);
        
        if (count($result['attached']) > 0) {
            $message = 'Followed ' . $user->name;
            event(new FollowNotify([
                'message' => '<a href="' . route('user.show', $authUser->id) . '">' . $authUser->name . '</a>' . ' has followed you!',
                'user_id' => $authUser->id,
                'user_name' => $authUser->name,
                'user_avatar' => $authUser->avatar
            ]));
            $user->notify(new UserFollowed($authUser));
        } elseif (count($result['detached']) > 0) {
            $message = 'Unfollowed ' . $user->name;
        } else {
            $message = 'Nothing changes.';
        }
        
        return redirect()->back()->with('success', $message);
    }

    public function likedPostsList()
    {
        $postsId = Like::where('user_id', Auth::id())->pluck('post_id');
        $posts = Post::whereIn('id', $postsId)->get();

        return view('account.likedList', compact('posts'));
    }
}
