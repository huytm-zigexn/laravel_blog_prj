<?php
namespace App\Http\Controllers\admin;

use App\Events\FollowNotify;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEditUserValidate;
use App\Models\User;
use App\Notifications\UserFollowed;
use App\QueryFilters\UserFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(UserFilter $filters)
    {
        $users = User::filter($filters)->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(AdminEditUserValidate $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = 'storage/' . $path;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Bạn không thể xóa chính mình.');
        }
        $user->delete();
        return back()->with('success', 'Xóa người dùng thành công');
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
        
        return redirect()->route('users.show', ['user' => $user->id])->with('success', $message);
    }
}
