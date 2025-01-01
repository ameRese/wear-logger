<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckItemOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ルートパラメータからアイテムを取得
        $item = $request->route('item');
        if (Auth::id() == $item->user_id) {
            return $next($request);
        }
        $request->session()->flash('error', '不正なアクセスです');
        return redirect()->route('item.index');
    }
}
