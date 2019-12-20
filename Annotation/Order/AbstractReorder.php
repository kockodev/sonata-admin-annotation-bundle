<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order\ShowAndFormReorderInterface;

abstract class AbstractReorder implements ReorderInterface
{
    /**
     * @var array
     */
    public $keys = array();

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }
}