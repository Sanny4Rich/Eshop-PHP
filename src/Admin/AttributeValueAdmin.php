<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Attribute;

class AttributeValueAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('product')
            ->add('attribute', ChoiceType:: class, [
                'choices' => [
                    'attribute.type.' .Attribute::TYPE_INT => Attribute::TYPE_INT,
                    'attribute.type.' .Attribute::TYPE_LIST => Attribute::TYPE_LIST,
                ]
            ])
            ->add('value');
    }

}