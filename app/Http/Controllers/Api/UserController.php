<?php

namespace App\Http\Controllers\Api;

use App\Employee;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Shows authenticated user information
     *
     * @authenticated
     *
     * @response 200 {
     *     "uid": 2,
     *     "displayName": "Demo",
     *     "email": "demo@demo.com",
     *     "role": "admin",
     *     "user_img": "demo.jpg"
     * }
     * @response status=400 scenario="Unauthenticated" {
     *     "message": "Unauthenticated."
     * }
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request)
    {

        $pi = Employee::where('user_id', $request->user()->id)->first();

        $role = $this->getRole($request->user()->type);

        return response()->json([
            'uid' => $request->user()->id,
            'displayName' => $request->user()->display_name,
            'email' => $request->user()->email,
            'role' => $role,
            'user_img' => $pi ? $pi->profile_image : null
        ]);
    }

    public function search(Request $request)
    {
        $user = 'nvp';

        if ($request->input('email'))
            $user = User::firstWhere('email', $request->input('email'));
        elseif ($request->input('user_id'))
            $user = User::find($request->input('user_id'));

        if ($user != 'nvp')
            if ($user)
                return response()->json($user->get(['id','display_name','email']));
            else
                return response()->json('No result found',404);
        else
            return response()->json('No valid parameters', 404);
    }

    public function setMyPassword(Request $request){

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);

        if (!Hash::check($request['old_password'], Auth::user()->password)) {
            return response()->json('The old password does not match our records.', 400);
        }

        if ($request['old_password'] == $request['new_password'] || $request['old_password'] == $request['password_confirmation']) {
            return response()->json('Old password and new password cannot be the same', 400);
        }

        $newPassword = User::find(Auth::user()->id);
        $newPassword->password = Hash::make($request->input('new_password'));
        $newPassword->save();

        return response()->json("Successfully Changed the password");
    }

    public function setPassword(Request $request){

        $user = User::find($request->route('user'));

        if(!$user)
            return response()->json('User Not Found.', 404);

        $this->validate($request, [
            'new_password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json("Successfully Changed the password");
    }

    private function getRole($val){
        $role = '';

        if ($val == '0') $role = 'sa';
        else if ($val == '1') $role = 'admin';
        else if ($val == '2') $role = 'employee';
        else if ($val == '3') $role = 'employer';

        return $role;
    }
}
