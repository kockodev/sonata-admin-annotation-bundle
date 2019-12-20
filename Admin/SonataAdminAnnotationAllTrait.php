<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Admin;

trait SonataAdminAnnotationAllTrait
{
    use SonataAdminAnnotationReaderTrait;
    use SonataAdminAnnotationDatagridMapperTrait;
    use SonataAdminAnnotationFormMapperTrait;
    use SonataAdminAnnotationShowMapperTrait;
    use SonataAdminAnnotationListMapperTrait;
}