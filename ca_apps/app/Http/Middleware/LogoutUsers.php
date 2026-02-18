<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AgentBackoffices;
use Session;

class LogoutUsers
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


       // $user = Auth::user();
        
        // You might want to create a method on your model to
        // prevent direct access to the `logout` property. Something
        // like `markedForLogout()` maybe.


         $findAgent = AgentBackoffices::where([
                  ['id', '=', Session::get('agentbackofficeid')],
                  ])->first();


        // if (! empty($user->logout)) {
        if ($findAgent->logout) {
            // code...
        
            // Not for the next time!
            // Maybe a `unmarkForLogout()` method is appropriate here.
            // $user->logout = false;
            // $user->save();
            
            // // Log her out
            // Auth::logout();
            return redirect('logout');
            // return redirect()->route('logout');
        }



        return $next($request);
    }
}
