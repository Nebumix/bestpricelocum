<?php

namespace Acme\PharmacyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PharmacyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gphc', 'text', array(
                'attr' => array('class' => 'text_short pharm', 'maxlength' => 10),
            ))
            //->add('id_owner', 'hidden', array('disabled' => true))
            /*->add('ownername', 'text', array(
                'attr' => array('class' => 'text_short pharm', 'maxlength' => 100),
            ))  */      
            ->add('name', 'text', array(
                'attr' => array('class' => 'text_short pharm'),
            ))
            //->add('state', 'text', array('disabled' => true, 'attr' => array('class' => 'text_short')))
            ->add('state', 'entity', array('label' => 'State', 
                'class' => 'AcmePharmacyBundle:States',
                'property' => 'name'
            ))                  
            //->add('country', 'text', array('disabled' => true, 'attr' => array('class' => 'text_short')))
            ->add('country', 'entity', array('label' => 'Country', 
                'class' => 'AcmePharmacyBundle:Countries',
                'property' => 'name'
            ))              
            ->add('city', 'text', array(
                'attr' => array('class' => 'text_short pharm'),
            ))
            ->add('postcode', 'text', array(
                'attr' => array('class' => 'text_short pharm'),
            ))
            ->add('address', 'text', array(
                'attr' => array('class' => 'text_short pharm'),
            ));

    }

    public function getName()
    {
        return 'pharmacy';
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\PharmacyBundle\Entity\Pharmacy',
        ));
    }



}
