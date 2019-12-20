<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation;

interface ShowInterface extends AdminInterface
{
    /**
     * @return string|null
     */
    public function getWith();

    /**
     * @return array
     */
    public function getWithOptions();
}