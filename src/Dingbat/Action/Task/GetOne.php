<?php


namespace Dingbat\Action\Task;

use Dingbat\Action;
use Dingbat\Model\Task;

/**
 * Class Get
 *
 * @category Action
 * @package  Dingbat\Action\Task
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class GetOne extends Action
{

    const CODE_ALL_FINE = 0;
    const CODE_TASK_DOES_NOT_EXIST = 1;


    /**
     * @return string
     */
    public function run()
    {
        $id = $this->request->get('id');

        // get task
        try {
            /* @var Task $task */
            $task = Task::get($id);

            return $this->response->send([
                'id'       => (int) $task->id,
                'cardId'   => (int) $task->cardid,
                'name'     => $task->name,
                'marked'   => (bool) $task->marked,
                'priority' => $task->priority,
                'code'     => GetOne::CODE_ALL_FINE,
                'message'  => 'all fine'
            ]);
        } catch (\Exception $e) {
            return $this->response->send([
                'id'       => null,
                'cardId'   => null,
                'name'     => null,
                'marked'   => null,
                'priority' => null,
                'code'     => GetOne::CODE_TASK_DOES_NOT_EXIST,
                'message'  => sprintf('task with `id` `%s` does not exist', $id)
            ]);
        }

    }
}
