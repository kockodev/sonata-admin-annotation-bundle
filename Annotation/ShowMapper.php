<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation;

/**
 * @Annotation
 */
class ShowMapper extends AbstractMapper implements ShowInterface
{
    /**
     * @var string
     */
    public $with = null;

    /**
     * @var array
     */
    public $withOptions = array();

    /**
     * @return null|string
     */
    public function getWith()
    {
        return $this->with;
    }

    /**
     * @return array
     */
    public function getWithOptions()
    {
        return $this->withOptions;
    }
}