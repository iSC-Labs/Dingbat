<?php


namespace Dingbat\Action\Task;

use Dingbat\Action;
use Dingbat\Model\Card;
use Dingbat\Model\Task;

/**
 * Class Update
 *
 * @category Action
 * @package  Dingbat\Action\Task
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class Update extends Action
{

    const CODE_ALL_FINE = 0;
    const CODE_TASK_DOES_NOT_EXIST = 1;
    const CODE_CARD_ID_IS_NOT_GIVEN = 2;
    const CODE_CARD_DOES_NOT_EXIST = 3;
    const CODE_NAME_IS_NOT_GIVEN = 4;
    const CODE_PRIORITY_IS_INVALID = 5;
    const CODE_UNKNOWN_ERROR = 999;


    /**
     * @param int $id ID of task
     * @return string
     */
    public function run($id)
    {
        $name     = $this->request->payload('name', false);
        $marked   = $this->request->payload('marked');
        $priority = $this->request->payload('priority', Task::PRIORITY_NORMAL);
        $cardid   = $this->request->payload('cardId', false);

        /* @var Task $task */
        $task = null;
        try {
            $task = Task::get($id);
        } catch (\Exception $e) {
            return $this->response->send([
                'code'    => Update::CODE_TASK_DOES_NOT_EXIST,
                'message' => sprintf('task with `id` `%d` does not exist', $id)
            ]);
        }

        // check if cardId is set
        if ($cardid === false) {
            return $this->response->send([
                'code'    => Update::CODE_CARD_ID_IS_NOT_GIVEN,
                'message' => 'param `cardId` is required'
            ]);
        }

        // check if cardId is exist
        if (!Card::exists($cardid)) {
            return $this->response->send([
                'code'    => Update::CODE_CARD_DOES_NOT_EXIST,
                'message' => sprintf('card with id `%d` does not exist', $cardid)
            ]);
        }

        // check if `name` is set
        if ($name === false) {
            return $this->response->send([
                'code'    => Update::CODE_NAME_IS_NOT_GIVEN,
                'message' => 'param `name` is required'
            ]);
        }

        // check if `priority` value
        if (!in_array($priority, ['normal', 'high', 'low'])) {
            return $this->response->send([
                'code'    => Update::CODE_PRIORITY_IS_INVALID,
                'message' => 'param `priority` must be `normal`, `high` or `low`'
            ]);
        }

        // save task
        try {
            $task->name     = $name;
            $task->marked   = $marked;
            $task->priority = $priority;
            $task->cardid   = $cardid;
            $task->update();

            return $this->response->send([
                'code'    => Update::CODE_ALL_FINE,
                'message' => 'all fine'
            ]);
        } catch (\Exception $e) {
            return $this->response->send([
                'code'    => Update::CODE_UNKNOWN_ERROR,
                'message' => $e->getMessage()
            ]);
        }
    }
}
