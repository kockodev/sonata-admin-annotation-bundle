<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Admin;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Reader\SonataAdminAnnotationReaderInterface;
use Sonata\AdminBundle\Admin\Pool;

trait SonataAdminAnnotationReaderTrait
{
    /**
     * @return SonataAdminAnnotationReaderInterface
     */
    protected function getSonataAnnotationReader()
    {
        return $this->getConfigurationPool()->getContainer()->get('ibrows_sonataadmin.annotation.reader');
    }

    /**
     * @return Pool
     */
    abstract protected function getConfigurationPool();
}