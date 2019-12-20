<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Reader;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\ListInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\ShowInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\FormInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\DatagridInterface;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\ShowCallbackInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\FormCallbackInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\DatagridCallbackInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\ListCallbackInterface;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order\ListReorderInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order\FormReorderInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order\ShowReorderInterface;

use Ibrows\AnnotationReader\AnnotationReaderInterface;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

interface SonataAdminAnnotationReaderInterface extends AnnotationReaderInterface
{
    const
        ANNOTATION_TYPE_ADMIN_LIST = 'ListInterface',
        ANNOTATION_TYPE_ADMIN_LIST_CALLBACK = 'ListCallbackInterface',
        ANNOTATION_TYPE_ADMIN_LIST_REORDER = 'ListReorderInterface',
        ANNOTATION_TYPE_ADMIN_LIST_EXCLUDE = 'ListExcludeInterface',
        ANNOTATION_TYPE_ADMIN_LIST_ALL = 'ListAllInterface',

        ANNOTATION_TYPE_ADMIN_SHOW = 'ShowInterface',
        ANNOTATION_TYPE_ADMIN_SHOW_REORDER = 'ShowReorderInterface',
        ANNOTATION_TYPE_ADMIN_SHOW_CALLBACK = 'ShowCallbackInterface',
        ANNOTATION_TYPE_ADMIN_SHOW_EXCLUDE = 'ShowExcludeInterface',
        ANNOTATION_TYPE_ADMIN_SHOW_ALL = 'ShowAllInterface',

        ANNOTATION_TYPE_ADMIN_DATAGRID = 'DatagridInterface',
        ANNOTATION_TYPE_ADMIN_DATAGRID_CALLBACK = 'DatagridCallbackInterface',
        ANNOTATION_TYPE_ADMIN_DATAGRID_EXCLUDE = 'DatagridExcludeInterface',
        ANNOTATION_TYPE_ADMIN_DATAGRID_ALL = 'DatagridAllInterface',

        ANNOTATION_TYPE_ADMIN_FORM = 'FormInterface',
        ANNOTATION_TYPE_ADMIN_FORM_REORDER = 'FormReorderInterface',
        ANNOTATION_TYPE_ADMIN_FORM_CALLBACK = 'FormCallbackInterface',
        ANNOTATION_TYPE_ADMIN_FORM_EXCLUDE = 'FormExcludeInterface',
        ANNOTATION_TYPE_ADMIN_FORM_ALL = 'FormAllInterface'
    ;

    /**
     * @param mixed $entity
     * @return ListInterface[]
     */
    public function getListMapperAnnotations($entity);

    /**
     * @param mixed $entity
     * @return ListCallbackInterface[]
     */
    public function getListMapperCallbacks($entity);

    /**
     * @param $entity
     * @return ListReorderInterface
     */
    public function getListReorderAnnotation($entity);

    /**
     * @param mixed $entity
     * @return ShowInterface[]
     */
    public function getShowMapperAnnotations($entity);

    /**
     * @param $entity
     * @return ShowCallbackInterface[]
     */
    public function getShowMapperCallbacks($entity);

    /**
     * @param $entity
     * @return ShowReorderInterface[]
     */
    public function getShowReorderAnnotations($entity);

    /**
     * @param mixed $entity
     * @return FormInterface[]
     */
    public function getFormMapperAnnotations($entity);

    /**
     * @param $entity
     * @return FormCallbackInterface[]
     */
    public function getFormMapperCallbacks($entity);

    /**
     * @param $entity
     * @return FormReorderInterface[]
     */
    public function getFormReorderAnnotations($entity);

    /**
     * @param mixed $entity
     * @return DatagridInterface[]
     */
    public function getDatagridMapperAnnotation($entity);

    /**
     * @param $entity
     * @return DatagridCallbackInterface[]
     */
    public function getDatagridMapperCallbacks($entity);

    /**
     * @param mixed $entity
     * @param ListMapper $listMapper
     * @return void
     */
    public function configureListFields($entity, ListMapper $listMapper);

    /**
     * @param mixed $entity
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @return void
     */
    public function configureFormFields($entity, FormMapper $formMapper);

    /**
     * @param mixed $entity
     * @param ShowMapper $showMapper
     * @return void
     */
    public function configureShowFields($entity, ShowMapper $showMapper);

    /**
     * @param mixed $entity
     * @param DatagridMapper $datagridMapper
     * @return void
     */
    public function configureDatagridFilters($entity, DatagridMapper $datagridMapper);
}