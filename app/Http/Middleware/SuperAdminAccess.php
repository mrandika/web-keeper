<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = Auth::user();

        if ($auth) {
            try {
                $user = User::findOrFail(Auth::user()->id);
                $admin = Admin::where('user_id', $user->id)->first();

                if ($user->role->name == 'Super-Admin') {
                    if (isset($admin)) {
                        if ($admin->status == 1) {
                            return $next($request);
                        } else {
                            Auth::logout();

                            return redirect(route('auth.login'))->with('info', 'Akun anda tidak aktif.');
                        }
                    } else {
                        Auth::logout();

                        return redirect(route('auth.login'))->with('info', 'Akun anda belum aktif.');
                    }
                } else {
                    session()->flash('info', [
                        'code' => 403,
                        'message' => 'Halaman ini tidak tersedia untuk anda.',
                        'back_url' => route('home')
                    ]);

                    return redirect(route('error'));
                }
            } catch (ModelNotFoundException) {
                return redirect(route('auth.login'))->with('info', 'Sesi anda telah habis, silahkan masuk kembali.');
            }
        }

        return redirect(route('auth.login'))->with('info', 'Silakan masuk untuk mengakses halaman ini.');
    }
}
