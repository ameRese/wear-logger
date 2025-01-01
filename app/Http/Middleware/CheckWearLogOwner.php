<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckWearLogOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ルートパラメータから着用記録を取得
        $wearLog = $request->route('wear_log');
        if (Auth::id() == $wearLog->item->user_id) {
            return $next($request);
        }
        $request->session()->flash('error', '不正なアクセスです');
        return redirect()->route('item.index');
    }
}
