<?php


namespace Dingbat;

use Dotor\Dotor;
use Phormium\DB;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
     * @var \Dotor\Dotor
     */
    protected $config;

    /**
     * @var App
     */
    protected static $instance;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var \Silex\Application
     */
    protected $silex;

    /**
     * @param string $rootDirectory Root of application (normally where the index.html is found)
     * @param array  $config        configuration of application
     */
    protected function __construct($rootDirectory, array $config = [])
    {
        // add route directory to $config
        $config['rootDirectory'] = $rootDirectory;

        // create config
        $this->config = new Dotor($config);

        // create app
        $this->silex          = new Application();
        $this->silex['debug'] = $this->config->getBool('debugging', false);

        // set instance of Request
        $this->silex->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }

            $this->request = $request;
        });

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
     * @return Dotor
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Application
     */
    public function getSilex()
    {
        return $this->silex;
    }

    /**
     * @param Action $action
     * @return Action
     */
    public function prepareAction(Action $action)
    {
        $action->setRequest($this->getRequest());
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
                    'dsn'      => sprintf(
                        'mysql:host=%s;dbname=%s',
                        $this->config->get('database.host'),
                        $this->config->get('database.name')
                    ),
                    'username' => $this->config->get('database.username'),
                    'password' => $this->config->get('database.password'),
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->silex->run();
    }

    /**
     * @return void
     */
    protected function setRoutes()
    {
        // cards
        $this->silex->post('/cards', function () {
            return $this->prepareAction(new Action\Card\Create())->run();
        });

        $this->silex->get('/cards', function () {
            return $this->prepareAction(new Action\Card\GetAll())->run();
        });

        $this->silex->get('/cards/{slug}', function ($slug) {
            return $this->prepareAction(new Action\Card\GetOne())->run($slug);
        });

        $this->silex->put('/cards/{slug}', function ($slug) {
            return $this->prepareAction(new Action\Card\Update())->run($slug);
        });

        $this->silex->delete('/cards/{slug}', function ($slug) {
            return $this->prepareAction(new Action\Card\Delete())->run($slug);
        });


        // tasks
        $this->silex->post('/task', function () {
            return $this->prepareAction(new Action\Task\Create())->run();
        });

        $this->silex->get('/task/{id}', function ($id) {
            return $this->prepareAction(new Action\Task\GetOne())->run($id);
        });

        $this->silex->get('/tasks', function () {
            return $this->prepareAction(new Action\Task\GetAll())->run();
        });

        $this->silex->get('/tasks/{filter}', function ($filter) {
            return $this->prepareAction(new Action\Task\GetAll())->run($filter);
        });

        $this->silex->put('/task/{id}', function ($id) {
            return $this->prepareAction(new Action\Task\Update())->run($id);
        });

        $this->silex->delete('/task/{id}', function ($id) {
            return $this->prepareAction(new Action\Task\Delete())->run($id);
        });

    }
}
