<?php

namespace Stoneworld\Wechat;

use Stoneworld\Wechat\Utils\Bag;

class Input extends Bag
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct(array_merge($_GET, $_POST));
    }
}
