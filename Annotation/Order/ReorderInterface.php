<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order;

interface ReorderInterface
{
    /**
     * @return array
     */
    public function getKeys();
}