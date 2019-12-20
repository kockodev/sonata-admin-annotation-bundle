<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Admin;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Reader\SonataAdminAnnotationReaderInterface;
use Sonata\AdminBundle\Show\ShowMapper;

trait SonataAdminAnnotationShowMapperTrait
{
    use SonataAdminAnnotationReaderTrait;

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->getSonataAnnotationReader()->configureShowFields($this->getClass(), $showMapper);
    }

    /**
     * @return SonataAdminAnnotationReaderInterface
     */
    abstract protected function getSonataAnnotationReader();
}