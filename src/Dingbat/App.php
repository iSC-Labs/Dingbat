<?php


namespace Dingbat;

use Hahns\Hahns;
use Hahns\Request;
use Hahns\Response;
use Phormium\DB;

/**
 * Class App
 *
 * @category Core
 * @package  Dingbat
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class App
{

    /**
     * @var App
     */
    protected static $instance;

    /**
     * @var Hahns
     */
    protected $hahns;

    /**
     * @param string $rootDirectory Root of application (normally where the index.html is found)
     * @param array  $config        configuration of application
     */
    protected function __construct($rootDirectory, array $config = [])
    {
        // create Hahns
        $this->hahns = new Hahns();

        // add root directory to $config
        $config['rootDirectory'] = $rootDirectory;

        // set config
        foreach ($config as $name => $value) {
            $this->hahns->config($name, $value);
        }

        $this->prepareDatabase();
        $this->setRoutes();
    }

    /**
     * @param string $projectRoot path to root path of project
     * @param array $config
     * @return App
     * @throws \InvalidArgumentException
     */
    public static function instance($projectRoot = null, array $config = [])
    {
        if (!(self::$instance instanceof App)) {
            if (is_null($projectRoot)) {
                $message = 'At first call of Dingbat::instance() is the $projectPath-parameter required';
                throw new \InvalidArgumentException($message);
            }

            self::$instance = new static($projectRoot, $config);
        }

        return self::$instance;
    }

    /**
     * @param Action $action
     * @param Request $request
     * @param Response $response
     * @return Action
     */
    public function prepareAction(Action $action, Request $request, Response $response)
    {
        $action->setRequest($request);
        $action->setResponse($response);
        return $action;
    }

    /**
     * @return void
     */
    protected function prepareDatabase()
    {
        DB::configure([
            'databases' => [
                'todo' => [
                    'dsn' => sprintf(
                        'mysql:host=%s;dbname=%s',
                        $this->hahns->config('db-host'),
                        $this->hahns->config('db-name')
                    ),
                    'username' => $this->hahns->config('db-username'),
                    'password' => $this->hahns->config('db-password')
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->hahns->run();
    }

    /**
     * @return void
     */
    protected function setRoutes()
    {
        // cards
        $this->hahns->post('/cards', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Card\Create(), $request, $response)->run();
        });

        $this->hahns->get('/cards', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Card\GetAll(), $request, $response)->run();
        });

        $this->hahns->get('/cards/[.+:slug]', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Card\GetOne(), $request, $response)->run();
        });

        $this->hahns->put('/cards/[.+:slug]', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Card\Update(), $request, $response)->run();
        });

        $this->hahns->delete('/cards/[.+:slug]', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Card\Delete(), $request, $response)->run();
        });


        // tasks
        $this->hahns->post('/task', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Task\Create(), $request, $response)->run();
        });

        $this->hahns->get('/task/[\d+:id]', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Task\GetOne(), $request, $response)->run();
        });

        $this->hahns->get('/tasks', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Task\GetAll(), $request, $response)->run();
        });

        $this->hahns->get('/tasks/[.+:filter]', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Task\GetAll(), $request, $response)->run();
        });

        $this->hahns->put('/task/[\d+:id]', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Task\Update(), $request, $response)->run();
        });

        $this->hahns->delete('/task/[\d+:id]', function (Request $request, Response\Json $response) {
            return $this->prepareAction(new Action\Task\Delete(), $request, $response)->run();
        });

    }
}
