<?php


namespace Dingbat\Action\Card;

use Dingbat\Action;
use Dingbat\Model\Card;

/**
 * Class Get
 *
 * @category Action
 * @package  Dingbat\Action\Card
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class GetOne extends Action
{

    const CODE_TASK_DOES_NOT_EXIST = 1;


    /**
     * @return string
     */
    public function run()
    {
        $slug = $this->request->get('slug');

        // get card
        try {
            /* @var Card $card */
            $card = Card::objects()->filter('slug', '=', $slug)->single();

            return $this->response->send([
                'id'   => (int) $card->id,
                'name' => $card->name,
                'slug' => $card->slug
            ]);
        } catch (\Exception $e) {
            return $this->response->send([
                'code'     => GetOne::CODE_TASK_DOES_NOT_EXIST,
                'message'  => 'card does not exist'
            ], 404);
        }

    }
}
