<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order;

interface FormReorderInterface extends ReorderInterface
{
    /**
     * @return string|null
     */
    public function getWith();
}