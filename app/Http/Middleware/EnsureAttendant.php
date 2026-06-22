<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class EnsureAttendant { public function handle(Request $request, Closure $next) { abort_unless($request->user()?->role==='attendant' && $request->user()?->is_active,403); return $next($request); } }
