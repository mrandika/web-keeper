<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActionLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $action)
    {
        try {
            $date = date('Y-m-d');
            $user = Auth::user();

            $data = '['.date('Y-m-d H:i:s').'] '.$user->id.' '.strtoupper($action).' - '. url()->current();
            $checksum = encrypt($data);

            Storage::disk('local')->append('keeper-'.$date.'.log', $data, PHP_EOL);
            Storage::disk('local')->append('keeper-'.$date.'.hash', $checksum, PHP_EOL);

            return $next($request);
        } catch (\Exception $e) {
            return redirect(route('auth.login'))->with('info', 'Sesi anda telah habis, silahkan masuk kembali.');
        }
    }
}
