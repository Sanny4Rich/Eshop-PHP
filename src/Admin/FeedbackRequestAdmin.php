<?php

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FeedbackRequestAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('email')
            ->addIdentifier('massage')
            ->addIdentifier('createdAt');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('name')
            ->add('email')
            ->add('massage')
            ->add('createdAt');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form ->add('name')
              ->add('name')
              ->add('email')
              ->add('massage');

    }


}