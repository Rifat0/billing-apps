<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Mail\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['role'] = User::REGULAR_USER;

        $user = User::create($data);
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->showOne($user, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:100|unique:users,name,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'min:6|confirmed',
            'role' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ]);

        if($request->has('name') && $user->name != $request->name) {
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email) {
            $user->email = $request->email;
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
        }

        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        if($request->has('role')){
            if(!$user->isVerified()){
                return $this->errorResponse('Only verified users can modify the role field', 409);
            }
            $user->role = $request->role;
        }

        if(!$user->isDirty()){
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $user->save();
        return $this->showOne($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user, 200);
    }

    /**
     * Verify the specified resource from storage.
     */
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->email_verified_at = now();
        $user->save();

        return $this->showMessage('Your email has been verified');
    }

    public function resendVerificationEmail(User $user)
    {
        if($user->isVerified()){
            return $this->errorResponse('This user is already verified', 409);
        }

        retry(5, function() use ($user){
            Mail::to($user)->send(new UserVerify($user));
        }, 100);

        return $this->showMessage('The verification email has been resend');
    }
}
