<?php


namespace Dingbat\Action\Card;

use Dingbat\Action;
use Dingbat\Helper\SlugHelper;
use Dingbat\Model\Card;

/**
 * Class Add
 *
 * @category Action
 * @package  Dingbat\Action\Card
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class Create extends Action
{

    const CODE_NAME_IS_REQUIRED = 1;
    const CODE_SLUG_IS_REQUIRED = 2;
    const CODE_SLUG_DUPLICATE   = 3;
    const CODE_UNKNOWN_ERROR = 999;

    /**
     * @return string
     */
    public function run()
    {
        $name    = $this->request->post('name', false);
        $slug    = strtolower($this->request->post('slug', ''));

        // check name
        if ($name === false) {
            return $this->response->send([
                'code'    => Create::CODE_NAME_IS_REQUIRED,
                'message' => '`name` is required',
            ], 400);
        }

        // check slug
        $slug = SlugHelper::convert($slug);
        if (strlen($slug) == 0) {
            return $this->response->send([
                'code'    => Create::CODE_SLUG_IS_REQUIRED,
                'message' => '`slug` is required'
            ], 400);
        }

        // duplicate slug
        if (Card::objects()->filter('slug', '=', $slug)->single(true) instanceof Card) {
            return $this->response->send([
                'code'    => Create::CODE_SLUG_DUPLICATE,
                'message' => 'duplicate entry for `slug`'
            ], 409);
        }

        // save card
        try {
            $card = new Card();
            $card->name = $name;
            $card->slug = $slug;
            $card->save();

            // addition location header
            $this->response->header('Location', sprintf('/cards/%s', $slug));

            return $this->response->send([
                'id' => (int) $card->id
            ], 201);
        } catch (\Exception $e) {
            return $this->response->send([
                'code'    => Create::CODE_UNKNOWN_ERROR,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
