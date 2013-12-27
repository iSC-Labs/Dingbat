<?php


namespace Dingbat\Model;

use Phormium\Model;

/**
 * Class Task
 *
 * @category Model
 * @package  Dingbat\Model
 * @author   Pierre Klink <dev@klinks.info>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/pklink/Dingbat
 */
class Card extends Model
{

    // @codingStandardsIgnoreStart
    /**
     * @var array
     */
    protected static $_meta = [
        'database' => 'todo',
        'table'    => 'cards',
        'pk'       => 'id'
    ];
    // @codingStandardsIgnoreEnd

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $slug;
}
