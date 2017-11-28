<?php
/**
 * Created by PhpStorm.
 * User: justfun
 * Date: 27.11.17
 * Time: 21:03
 */

namespace App\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class PreviousRequestParamsMiddleware
 * @package App\Middleware
 */
class PreviousRequestParamsMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        $this->container->view->addGlobal('previous', $_SESSION['previous_request_params']);
        $_SESSION['previous_request_params'] = $request->getParams();

        $response = $next($request, $response);
        return $response;
    }
}