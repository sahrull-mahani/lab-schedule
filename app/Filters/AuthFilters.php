<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilters implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!function_exists('logged_in')) {
            helper('auth');
        }

        $current = (string)current_url(true)
            ->setHost('')
            ->setScheme('')
            ->stripQuery('token');

        $config = config(App::class);
        if ($config->forceGlobalSecureRequests) {
            # Remove "https:/"
            $current = substr($current, 7);
        }

        // Make sure this isn't already a login route
        if (in_array((string)$current, [
            route_to('login'),
            route_to('log-in'),
            route_to('forgot-password'),
            route_to('forgot_password'),
            route_to('reset-password'),
            route_to('activate-account'),
            route_to('apilaporan'),
            route_to('apilogin'),
            route_to('apisetting'),
            route_to('auth/save'),
            route_to('/'),
        ])) {
            return;
        }

        if (!logged_in()) {
            session()->set('redirect_url', current_url());
            return redirect('login');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
