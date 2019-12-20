<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Admin;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Reader\SonataAdminAnnotationReaderInterface;
use Sonata\AdminBundle\Form\FormMapper;

trait SonataAdminAnnotationFormMapperTrait
{
    use SonataAdminAnnotationReaderTrait;

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->getSonataAnnotationReader()->configureFormFields($this->getClass(), $formMapper);
    }

    /**
     * @return SonataAdminAnnotationReaderInterface
     */
    abstract protected function getSonataAnnotationReader();
}