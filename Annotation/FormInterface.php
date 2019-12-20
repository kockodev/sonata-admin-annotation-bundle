<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation;

interface FormInterface extends AdminInterface
{
    /**
     * @return array
     */
    public function getOptions();

    /**
     * @return string|null
     */
    public function getWith();

    /**
     * @return array
     */
    public function getWithOptions();
}