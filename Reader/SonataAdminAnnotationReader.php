<?php

namespace Ibrows\Bundle\SonataAdminAnnotationBundle\Reader;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\ListMapper;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\ShowMapper;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\FormMapper;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\DatagridMapper;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\ShowCallbackInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\FormCallbackInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\ListCallbackInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\DatagridCallbackInterface;

use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order\ListReorderInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order\FormReorderInterface;
use Ibrows\Bundle\SonataAdminAnnotationBundle\Annotation\Order\ShowReorderInterface;

use Ibrows\AnnotationReader\AnnotationReader;

use Sonata\AdminBundle\Datagrid\ListMapper as SonataListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper as SonataDatagridMapper;
use Sonata\AdminBundle\Form\FormMapper as SonataFormMapper;
use Sonata\AdminBundle\Show\ShowMapper as SonataShowMapper;

class SonataAdminAnnotationReader extends AnnotationReader implements SonataAdminAnnotationReaderInterface
{
    /**
     * @inheritdoc
     */
    public function getListMapperAnnotations($entity)
    {
        $listAnnotations = $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_LIST, self::SCOPE_PROPERTY);
        if(!$this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_LIST_ALL, self::SCOPE_CLASS)){
            return $listAnnotations;
        }

        $listExcludeAnnotations = $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_LIST_EXCLUDE, self::SCOPE_PROPERTY);

        return $this->collectAllAnnotations(
            $listAnnotations,
            $listExcludeAnnotations,
            $this->getReflectionProperties($entity),
            new ListMapper()
        );
    }

    /**
     * @inheritdoc
     */
    public function getShowMapperAnnotations($entity)
    {
        $showAnnotations = $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_SHOW, self::SCOPE_PROPERTY);
        if(!$this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_SHOW_ALL, self::SCOPE_CLASS)){
            return $showAnnotations;
        }

        $showExcludeAnnotations = $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_SHOW_EXCLUDE, self::SCOPE_PROPERTY);

        return $this->collectAllAnnotations(
            $showAnnotations,
            $showExcludeAnnotations,
            $this->getReflectionProperties($entity),
            new ShowMapper()
        );
    }

    /**
     * @inheritdoc
     */
    public function getFormMapperAnnotations($entity)
    {
        $formAnnotations = $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_FORM, self::SCOPE_PROPERTY);
        if(!$this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_FORM_ALL, self::SCOPE_CLASS)){
            return $formAnnotations;
        }

        $formExcludeAnnotations = $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_FORM_EXCLUDE, self::SCOPE_PROPERTY);

        return $this->collectAllAnnotations(
            $formAnnotations,
            $formExcludeAnnotations,
            $this->getReflectionProperties($entity),
            new FormMapper()
        );
    }

    /**
     * @inheritdoc
     */
    public function getDatagridMapperAnnotation($entity)
    {
        $datagridAnnotations = $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_DATAGRID, self::SCOPE_PROPERTY);
        if(!$this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_DATAGRID_ALL, self::SCOPE_CLASS)){
            return $datagridAnnotations;
        }

        $datagridExcludeAnnotations = $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_DATAGRID_EXCLUDE, self::SCOPE_PROPERTY);

        return $this->collectAllAnnotations(
            $datagridAnnotations,
            $datagridExcludeAnnotations,
            $this->getReflectionProperties($entity),
            new DatagridMapper()
        );
    }

    /**
     * @inheritdoc
     */
    public function configureListFields($entity, SonataListMapper $listMapper)
    {
        $annotations = $this->getListMapperAnnotations($entity);

        foreach($annotations as $propertyName => $annotation){
            $method = $annotation->isIdentifier() ? 'addIdentifier' : 'add';

            $fieldDescriptionOptions = $annotation->getFieldDescriptionOptions();
            $routeName = $annotation->getRouteName();
            if($routeName){
                $fieldDescriptionOptions['route'] = array('name' => $routeName);
            }

            $listMapper->$method(
                $annotation->getName() ?: $propertyName,
                $annotation->getType(),
                $fieldDescriptionOptions
            );
        }

        $this->invokeCallbacks($entity, $this->getListMapperCallbacks($entity), array($listMapper));

        $reorder = $this->getListReorderAnnotation($entity);
        if($reorder){
            $listMapper->reorder($reorder->getKeys());
        }
    }

    /**
     * @inheritdoc
     */
    public function configureFormFields($entity, SonataFormMapper $formMapper)
    {
        $annotations = $this->getFormMapperAnnotations($entity);

        foreach($annotations as $propertyName => $annotation){
            $with = $annotation->getWith();
            if($with){
                $formMapper->with($with);
            }

            $formMapper->add(
                $annotation->getName() ?: $propertyName,
                $annotation->getType(),
                $annotation->getOptions(),
                $annotation->getFieldDescriptionOptions()
            );

            if($with){
                $formMapper->end();
            }
        }

        $this->invokeCallbacks($entity, $this->getFormMapperCallbacks($entity), array($formMapper));

        foreach($this->getFormReorderAnnotations($entity) as $formReorderAnnotation){
            $formMapper->with($formReorderAnnotation->getWith());
            $formMapper->reorder($formReorderAnnotation->getKeys());
            $formMapper->end();
        }
    }

    /**
     * @inheritdoc
     */
    public function configureShowFields($entity, SonataShowMapper $showMapper)
    {
        $annotations = $this->getShowMapperAnnotations($entity);

        foreach($annotations as $propertyName => $annotation){
            $with = $annotation->getWith();
            if($with){
                $showMapper->with($with, $annotation->getWithOptions());
            }

            $showMapper->add(
                $annotation->getName() ?: $propertyName,
                $annotation->getType(),
                $annotation->getFieldDescriptionOptions()
            );

            if($with){
                $showMapper->end($with);
            }
        }

        $this->invokeCallbacks($entity, $this->getShowMapperCallbacks($entity), array($showMapper));

        foreach($this->getShowReorderAnnotations($entity) as $showReorderAnnotation){
            $showMapper->with($showReorderAnnotation->getWith());
            $showMapper->reorder($showReorderAnnotation->getKeys());
            $showMapper->end();
        }
    }

    /**
     * @inheritdoc
     */
    public function configureDatagridFilters($entity, SonataDatagridMapper $datagridMapper)
    {
        $annotations = $this->getDatagridMapperAnnotation($entity);

        foreach($annotations as $propertyName => $annotation){
            $datagridMapper->add(
                $annotation->getName() ?: $propertyName,
                $annotation->getType(),
                $annotation->getFilterOptions(),
                $annotation->getFieldType(),
                $annotation->getFieldOptions()
            );
        }

        $this->invokeCallbacks($entity, $this->getDatagridMapperCallbacks($entity), array($datagridMapper));
    }

    /**
     * @param $entity
     * @return FormCallbackInterface[]
     */
    public function getFormMapperCallbacks($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_FORM_CALLBACK, self::SCOPE_METHOD);
    }

    /**
     * @param $entity
     * @return ShowCallbackInterface[]
     */
    public function getShowMapperCallbacks($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_SHOW_CALLBACK, self::SCOPE_METHOD);
    }

    /**
     * @param mixed $entity
     * @return ListCallbackInterface[]
     */
    public function getListMapperCallbacks($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_LIST_CALLBACK, self::SCOPE_METHOD);
    }

    /**
     * @param $entity
     * @return DatagridCallbackInterface[]
     */
    public function getDatagridMapperCallbacks($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_DATAGRID_CALLBACK, self::SCOPE_METHOD);
    }

    /**
     * @param $entity
     * @return ListReorderInterface
     */
    public function getListReorderAnnotation($entity)
    {
        return $this->getAnnotationsByType($entity, self::ANNOTATION_TYPE_ADMIN_LIST_REORDER, self::SCOPE_CLASS);
    }

    /**
     * @param $entity
     * @return FormReorderInterface[]
     */
    public function getFormReorderAnnotations($entity)
    {
        $annotations = $this->getAnnotations($entity);
        $scopeAnnotations = $annotations[self::SCOPE_CLASS];
        if(!isset($scopeAnnotations[self::ANNOTATION_TYPE_ADMIN_FORM_REORDER])){
            return array();
        }

        return $scopeAnnotations[self::ANNOTATION_TYPE_ADMIN_FORM_REORDER];
    }

    /**
     * @param $entity
     * @return ShowReorderInterface[]
     */
    public function getShowReorderAnnotations($entity)
    {
        $annotations = $this->getAnnotations($entity);
        $scopeAnnotations = $annotations[self::SCOPE_CLASS];
        if(!isset($scopeAnnotations[self::ANNOTATION_TYPE_ADMIN_SHOW_REORDER])){
            return array();
        }

        return $scopeAnnotations[self::ANNOTATION_TYPE_ADMIN_SHOW_REORDER];
    }

    /**
     * @param array $foundAnnotations
     * @param array $excludedAnnotations
     * @param array $properties
     * @param mixed $prototypeAnnotation
     * @return array
     */
    protected function collectAllAnnotations(array $foundAnnotations, array $excludedAnnotations, array $properties, $prototypeAnnotation)
    {
        $annotations = array();

        foreach($properties as $reflectionProperty){
            $propertyName = $reflectionProperty->getName();
            if(isset($excludedAnnotations[$propertyName])){
                continue;
            }
            if(isset($foundAnnotations[$propertyName])){
                $annotations[$propertyName] = $foundAnnotations[$propertyName];
                continue;
            }
            $annotations[$propertyName] = clone $prototypeAnnotation;
        }

        return $annotations;
    }

    /**
     * @param string $className
     * @return \ReflectionProperty[]
     */
    protected function getReflectionProperties($className)
    {
        $reflectionClass = new \ReflectionClass($className);
        return $reflectionClass->getProperties();
    }

    /**
     * @param string $entity
     * @param array $callbacks
     * @param array $args
     */
    protected function invokeCallbacks($entity, array $callbacks, array $args)
    {
        if(count($callbacks) > 0){
            $classReflection = new \ReflectionClass($entity);
            foreach($callbacks as $methodName => $annotation){
                $method = $classReflection->getMethod($methodName);
                $method->invokeArgs(null, $args);
            }
        }
    }
}