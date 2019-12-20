<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order;

/**
 * @Annotation
 */
class ShowReorder extends AbstractReorder implements ShowReorderInterface
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