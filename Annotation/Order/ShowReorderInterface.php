<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order;

interface ShowReorderInterface extends ReorderInterface
{
    /**
     * @return string|null
     */
    public function getWith();
}