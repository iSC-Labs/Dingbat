<?php


namespace Dingbat\Action\Task;

use Dingbat\Action;
use Dingbat\Model\Card;
use Dingbat\Model\Task;

/**
 * Class Add
 *
 * @category Action
 * @package  Dingbat\Action\Task
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class Create extends Action
{

    const CODE_ALL_FINE = 0;
    const CODE_CARD_ID_IS_NOT_GIVEN = 1;
    const CODE_CARD_DOES_NOT_EXIST = 2;
    const CODE_NAME_IS_NOT_GIVEN = 3;
    const CODE_PRIORITY_IS_INVALID = 4;
    const CODE_UNKNOWN_ERROR = 999;

    /**
     * @return string
     */
    public function run()
    {
        $name     = $this->request->post('name', false);
        $marked   = $this->request->post('marked', false);
        $priority = $this->request->post('priority', Task::PRIORITY_NORMAL);
        $cardid   = $this->request->post('cardId', false);

        // check if cardId is set
        if ($cardid === false) {
            return $this->response->send([
                'id'      => null,
                'code'    => Create::CODE_CARD_ID_IS_NOT_GIVEN,
                'message' => 'param `cardId` is required'
            ]);
        }

        // check if cardId is exist
        if (!Card::exists($cardid)) {
            return $this->response->send([
                'id'      => null,
                'code'    => Create::CODE_CARD_DOES_NOT_EXIST,
                'message' => sprintf('card with id `%d` does not exist', $cardid)
            ]);
        }

        // check if `name` is set
        if ($name === false) {
            return $this->response->send([
                'id'      => null,
                'code'    => Create::CODE_NAME_IS_NOT_GIVEN,
                'message' => 'param `name` is required'
            ]);
        }

        // check if `priority` value
        if (!in_array($priority, ['normal', 'high', 'low'])) {
            return $this->response->send([
                'id'      => null,
                'code'    => Create::CODE_PRIORITY_IS_INVALID,
                'message' => 'param `priority` must be `normal`, `high` or `low`'
            ]);
        }

        // save task
        try {
            $task = new Task();
            $task->name     = $name;
            $task->marked   = $marked;
            $task->priority = $priority;
            $task->cardid   = $cardid;
            $task->save();

            return $this->response->send([
                'id'      => (int) $task->id,
                'code'    => Create::CODE_ALL_FINE,
                'message' => 'all fine'
            ]);
        } catch (\Exception $e) {
            return $this->response->send([
                'id'      => null,
                'code'    => Create::CODE_UNKNOWN_ERROR,
                'message' => $e->getMessage()
            ]);
        }
    }
}