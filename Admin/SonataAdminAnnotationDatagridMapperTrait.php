<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Admin;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Reader\SonataAdminAnnotationReaderInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

trait SonataAdminAnnotationDatagridMapperTrait
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->getSonataAnnotationReader()->configureDatagridFilters($this->getClass(), $datagridMapper);
    }

    /**
     * @return SonataAdminAnnotationReaderInterface
     */
    abstract protected function getSonataAnnotationReader();
}