    <?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Closure;

use App\Models\User;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    public function handle(Request $request,closure $next)
    {
        if(Auth::check())
        {
            return $next($request);
        }else{
            throw new HttpException(404);
        }
    }
}
