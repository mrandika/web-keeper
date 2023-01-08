<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AuthBridgeController extends Controller
{
    public function divert()
    {
        try {
            $user = User::findOrFail(Auth::user()->id);

            if ($user->role->name == 'Super-Admin') {
                return redirect(route('superadmin.home'));
            } else if ($user->role->name == 'Admin') {
                return redirect(route('admin.home'));
            } else if ($user->role->name == 'Employee') {
                return redirect(route('employee.home'));
            }
        } catch (ModelNotFoundException) {
            return redirect(route('auth.login'))->with('info', 'Sesi anda telah habis, silahkan masuk kembali.');
        }
    }
}
