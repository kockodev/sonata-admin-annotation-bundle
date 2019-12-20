<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Admin;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Reader\SonataAdminAnnotationReaderInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;

trait SonataAdminAnnotationListMapperTrait
{
    use SonataAdminAnnotationReaderTrait;

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->getSonataAnnotationReader()->configureListFields($this->getClass(), $listMapper);
    }

    /**
     * @return SonataAdminAnnotationReaderInterface
     */
    abstract protected function getSonataAnnotationReader();
}