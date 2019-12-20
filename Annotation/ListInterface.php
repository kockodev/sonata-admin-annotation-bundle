<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation;

interface ListInterface extends AdminInterface
{
    /**
     * @return boolean
     */
    public function isIdentifier();

    /**
     * @return string|null
     */
    public function getRouteName();
}