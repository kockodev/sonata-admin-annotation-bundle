<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order;

/**
 * @Annotation
 */
class FormReorder extends AbstractReorder implements FormReorderInterface
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