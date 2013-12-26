<?php


namespace Dingbat\Action\Task;

use Dingbat\Action;
use Dingbat\Model\Task;

/**
 * Class Delete
 *
 * @category Action
 * @package  Dingbat\Action\Task
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class Delete extends Action
{

    const CODE_ALL_FINE = 0;
    const CODE_TASK_DOES_NOT_EXIST = 1;
    const CODE_UNKNOW_ERROR = 999;


    /**
     * @param integer $id ID of task
     * @return string
     */
    public function run($id)
    {
        $task = null;

        // get task
        try {
            $task = Task::get($id);
        } catch (\Exception $e) {
            return $this->response->send([
                'code'    => Delete::CODE_TASK_DOES_NOT_EXIST,
                'message' => sprintf('task with `id` `%d` does not exist', $id)
            ]);
        }

        // delete task
        try {
            $task->delete();

            return $this->response->send([
                'code'    => Delete::CODE_ALL_FINE,
                'message' => 'all fine'
            ]);
        } catch (\Exception $e) {
            return $this->response->send([
                'code'    => Delete::CODE_UNKNOW_ERROR,
                'message' => $e->getMessage()
            ]);
        }
    }
}
