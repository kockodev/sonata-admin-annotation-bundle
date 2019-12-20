<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order;

interface ShowAndFormReorderInterface extends ShowReorderInterface, FormReorderInterface
{
    /**
     * @return string|null
     */
    public function getWith();
}