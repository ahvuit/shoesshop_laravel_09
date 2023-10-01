<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * The headers that should be added to all JSON responses.
     *
     * @var array
     */
    protected $jsonHeaders = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    /**
     * Add the JSON headers to the response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     * @return \Illuminate\Http\Response
     */
    protected function addJsonHeaders($request, $response)
    {
        foreach ($this->jsonHeaders as $name => $value) {
            $response->header($name, $value);
        }

        return $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $this->addJsonHeaders($request, $response);
        }

        return $response;
    }
}
