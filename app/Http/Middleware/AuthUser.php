<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            // ၁။ Axios နဲ့ ပို့တဲ့ Request (JSON) ဖြစ်နေရင် 401 ပဲ ပြန်မယ်
            if ($request->expectsJson()) {
                abort(401, 'Unauthorized');
            }

            // ၂။ Inertia ဒါမှမဟုတ် သာမန် Link တွေဆိုရင် Login ဆီ Redirect လုပ်မယ်
            // fullUrl() ကို သုံးရင် parameter တွေပါ ပါသွားမယ် (ဥပမာ ?page=2)
            return redirect()->route('login', [
                'redirect' => $request->fullUrl()
            ]);
        }

        return $next($request);
    }
}
