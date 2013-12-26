<?php


namespace Dingbat\Action\Card;

use Dingbat\Action;
use Dingbat\Model\Card;
use Dingbat\Model\Task;

/**
 * Class Delete
 *
 * @category Action
 * @package  Dingbat\Action\Card
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class Delete extends Action
{

    /**
     * @return string
     */
    public function run()
    {
        $slug = $this->request->get('slug');

        // get card and delete it
        try {
            /* @var Card $card */
            $card = Card::objects()->filter('slug', '=', $slug)->single();

            // delete all tasks of the card
            $tasks = Task::objects()->filter('cardid', '=', $card->id)->fetch();

            foreach ($tasks as $task) {
                /* @var \Dingbat\Model\Task $task */
                $task->delete();
            }

            // delete card
            $card->delete();
        } catch (\Exception $e) {
        }

        $this->response->status(204);
        return '';
    }
}
