<?php

namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->remove('username');
		$builder->add('employer', 'choice', array(
		    'choices'   => array(
		        '1'   => 'Are you an employer and are you looking for staff?',
		        '0' => 'Are you looking for a job?',
		    ),
		    'expanded' => true,
		    'multiple'  => false,
		));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'acme_user_registration';
    }
}