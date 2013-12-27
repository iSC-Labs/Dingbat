<?php


namespace Dingbat;

use Hahns\Request;
use Hahns\Response;
use Hahns\Services;

/**
 * Class Action
 *
 * @category Action
 * @package  Dingbat
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
abstract class Action
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Services
     */
    protected $services;

    /**
     * @return string
     */
    abstract public function run();

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Response $respone
     */
    public function setResponse(Response $respone)
    {
        $this->response = $respone;
    }

    /**
     * @param Services $services
     */
    public function setServices(Services $services)
    {
        $this->services = $services;
    }
}
