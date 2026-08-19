<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Read locale from URL prefix: /id/... or /en/...
        $localeFromUrl = $request->segment(1);

        if (in_array($localeFromUrl, ['en', 'id'])) {
            App::setLocale($localeFromUrl);
            Session::put('locale', $localeFromUrl);
            \Carbon\Carbon::setLocale($localeFromUrl);
            
            // Penting: Hapus parameter 'locale' agar tidak mengganggu parameter di Controller
            if ($request->route()) {
                $request->route()->forgetParameter('locale');
            }
        } elseif (Session::has('locale')) {
            $sessLocale = Session::get('locale');
            App::setLocale($sessLocale);
            \Carbon\Carbon::setLocale($sessLocale);
        } else {
            App::setLocale('id');
            \Carbon\Carbon::setLocale('id');
        }

        return $next($request);
    }
}
