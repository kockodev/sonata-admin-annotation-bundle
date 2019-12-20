<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order;

/**
 * @Annotation
 */
class ShowAndFormReorder extends AbstractReorder implements ShowAndFormReorderInterface
{
    /**
     * @var string
     */
    public $with = null;

    /**
     * @return string|null
     */
    public function getWith()
    {
        return $this->with;
    }
}