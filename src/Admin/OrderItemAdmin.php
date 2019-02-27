<?php
/**
 * Created by PhpStorm.
 * User: sanny4rich
 * Date: 27.02.19
 * Time: 19:51
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class OrderItemAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('product')
            ->add('ProductPrice')
            ->add('count');
    }

}