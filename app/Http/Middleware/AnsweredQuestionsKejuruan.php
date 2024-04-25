<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AnsweredQuestionsKejuruan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_id = Auth::user()->id;
        $userExist = DB::table('m_hasil_tes')
                    ->where([
                        'jenis_soal' => 'kejuruan',
                        'user_id' => $user_id
                    ])->count();
        
        if(!$userExist) 
            return $next($request);

        return redirect('/')->with('error',"kamu gak punya akses");
    }
}
