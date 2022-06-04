<?php

namespace App\Http\Middleware\Tenanty;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Http\Request;

class TenantyMiddleware
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
        $manager = app(ManagerTenant::class);

        if ($manager->domainIsMain()) {
            return $next($request);
        }

        $company = $this->getCompany($request->getHost());

        if (!$company && $request->url() != route('404.tenanty'))
            return redirect()->route('404.tenanty');
        else if ($request->url() != route('404.tenanty'))
            $manager->setConection($company);


        return $next($request);
    }

    public function getCompany($host)
    {
        return Company::where('domain', $host)->first();
    }
}
