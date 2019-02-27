<?php

namespace App\Admin;


use App\Entity\Product;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;

class OrderAdmin extends AbstractAdmin
{
    /**
     * @var CacheManager
     *
     */

    protected function configureListFields(ListMapper $list)
    {
        $list
            -> addIdentifier('id')
            -> addIdentifier('createdAt')
            -> addIdentifier('status')
            -> addIdentifier('PayStatus')
            -> addIdentifier('firstName')
            -> addIdentifier('lastName')
            -> addIdentifier('OrderPrice')
            -> addIdentifier('user')
            -> addIdentifier('PhoneNumber')
            -> addIdentifier('adress');

    }
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            -> add('id')
            -> add('user')
            -> add('createdAt')
            -> add('OrderPrice');
    }
    protected function configureFormFields(FormMapper $form)
    {
        $form
            -> add('createdAt')
            -> add('status')
            -> add('PayStatus')
            -> add('firstName')
            -> add('lastName')
            -> add('OrderPrice')
            -> add('user')
            -> add('PhoneNumber')
            -> add('adress')
            ->add('items', CollectionType::class, ['by_reference' => false], [
                'edit' => 'inline',
                'inline' => 'table'
            ]
        );
    }
}