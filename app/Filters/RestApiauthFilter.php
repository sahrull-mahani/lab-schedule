<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RestApiauthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $username = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : "";
		$password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : "";

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
            route_to('apilaporan'),
            route_to('apilogin'),
            ])
        ) {
            if($username != "ace" || $password != "ace21"){
          
                header("Content-type: application/json");
              
                echo json_encode(array(
                    "status" => false,
                    "message" => "Invalid credentials"
                ));
                die;
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
