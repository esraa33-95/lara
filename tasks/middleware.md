<h1>middleware</h1>
definition:Middleware provide a convenient mechanism for inspecting and filtering HTTP requests entering your application.
<h2><b>1.Defining Middleware</b></h2>
<b>php artisan make: middleware EnsureTokenIsValid</b>

<p>This command will place a new EnsureTokenIsValid class within your app/Http/Middleware directory. In this middleware, we will only allow access to the route if the supplied token input matches a specified value.</p>

<h2>2.add this code to app/Http/Middleware directory </h2>

        public function handle(Request $request, Closure $next): Response
    {
        if ($request->input('token') !== 'my-secret-token') {
            return redirect('/home');
        }
 
        return $next($request);
    }

    
   <b> Middleware and Responses</b>
   <p> For example, the following middleware would perform some task before the request is handled by the application:</p>

   class BeforeMiddleware
   {

    public function handle(Request $request, Closure $next): Response
    {
        // Perform action
 
        return $next($request);
    } }

   <b> this middleware would perform its task after the request is handled by the application:</b>

   class AfterMiddleware{

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
 
        // Perform action
 
        return $response;
    } }


     Registering Middleware:

      1.append it to the global middleware stack in your application's bootstrap/app.php 


      use App\Http\Middleware\EnsureTokenIsValid;
 
     ->withMiddleware(function (Middleware $middleware) {
     $middleware->append(EnsureTokenIsValid::class);
})

The append method adds the middleware to the end of the list of global middleware. If you would like to add a middleware to the beginning of the list, you should use the prepend method.

Assigning Middleware to Routes:

use App\Http\Middleware\EnsureTokenIsValid;
 
Route::get('cars/create',[CarController::class,'create'])
->name('cars.create')->middleware(EnsureTokenIsValid::class);


2.Manually Managing Laravel's Default Global Middleware
->withMiddleware(function (Middleware $middleware) {
    $middleware->use([
        // \Illuminate\Http\Middleware\TrustHosts::class,
        \Illuminate\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ]);
})

web.php
Route::get('/', function () {
    // ...
})->middleware([First::class, Second::class]);



Excluding Middleware:
to prevent the middleware from being applied to an individual route within the group. You may accomplish this using the withoutMiddleware method:

use App\Http\Middleware\EnsureTokenIsValid;
 
Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('/', function () {
        // ...
    });
 
    Route::get('/profile', function () {
        // ...
    })->withoutMiddleware([EnsureTokenIsValid::class]);
});

<h2>Middleware Groups</h2>
Sometimes you may want to group several middleware under a single key to make them easier to assign to routes.
use App\Http\Middleware\First;
use App\Http\Middleware\Second;
 
->withMiddleware(function (Middleware $middleware) {
    $middleware->appendToGroup('group1', [
        First::class,
        Second::class,
    ]);
 
    $middleware->prependToGroup('group2', [
        First::class,
        Second::class,
    ]); })

    -go to web.php

    Route::get('/', function () {
    // ...
})->middleware('group1');

Route::middleware(['group2'])->group(function () {
    // ...
});

1.The web Middleware Group:

Illuminate\Cookie\Middleware\EncryptCookies
Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse
Illuminate\Session\Middleware\StartSession
Illuminate\View\Middleware\ShareErrorsFromSession
Illuminate\Foundation\Http\Middleware\ValidateCsrfToken
Illuminate\Routing\Middleware\SubstituteBindings

2.The api Middleware Group
Illuminate\Routing\Middleware\SubstituteBindings

- may use the web and api methods within your application's bootstrap/app.php

use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Middleware\EnsureUserIsSubscribed;
 
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        EnsureUserIsSubscribed::class,
    ]);
 
    $middleware->api(prepend: [
        EnsureTokenIsValid::class,
    ]);
})

-manual

->withMiddleware(function (Middleware $middleware) {
    $middleware->group('web', [
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        // \Illuminate\Session\Middleware\AuthenticateSession::class,
    ]);
 
    $middleware->group('api', [
        // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        // 'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);
})

Middleware Aliases:

Middleware aliases allow you to define a short alias for a given middleware class, which can be especially useful for middleware with long class names:

use App\Http\Middleware\EnsureUserIsSubscribed;
 
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'subscribed' => EnsureUserIsSubscribed::class
    ]);
})

-go to web

Route::get('/profile', function () {
    // ...
})->middleware('subscribed');

subscribed =>\Spark\Http\Middleware\VerifyBillableIsSubscribed

Middleware Parameters:
 For example, if your application needs to verify that the authenticated user has a given "role" before performing a given action, you could create an EnsureUserHasRole middleware that receives a role name as an additional argument.

 <?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()->hasRole($role)) {
            // Redirect...
        }
 
        return $next($request);
    }
 
}

-go to web.php
-Middleware parameters may be specified when defining the route by separating the middleware name and parameters with a ::

Route::put('/post/{id}', function (string $id) {
    // ...
})->middleware('role:editor,publisher');

Terminable Middleware:
The terminate method should receive both the request and the response. Once you have defined a terminable middleware, you should add it to the list of routes or global middleware in your application's bootstrap/app.php file.

<?php
 
namespace Illuminate\Session\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class TerminatingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
 
    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        // ...
    }
}

go to AppServiceProvider:

use App\Http\Middleware\TerminatingMiddleware;
 
/**
 * Register any application services.
 */
public function register(): void
{
    $this->app->singleton(TerminatingMiddleware::class);
}





















