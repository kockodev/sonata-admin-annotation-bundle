<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation;

interface AdminInterface
{
    /**
     * @return null|string
     */
    public function getName();

    /**
     * @return null|string
     */
    public function getType();

    /**
     * @return array
     */
    public function getFieldDescriptionOptions();
}