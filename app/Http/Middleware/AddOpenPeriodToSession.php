<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Finance_cln_periods;

class AddOpenPeriodToSession
{
    public function handle(Request $request, Closure $next)
{
    $user = auth('admin')->user(); // ← استخدم الحارس admin

    if ($user) {
        if (!session()->has('open_period')) {
            $com_code = $user->com_code;

            $open_period = Finance_cln_periods::where('com_code', $com_code)
                ->whereHas('mainSalaryRecord', function ($query) {
                    $query->where('is_open', 1);
                })
                ->latest()
                ->first();

            session(['open_period' => $open_period]);
        }
    }

    return $next($request);
}

    
}

