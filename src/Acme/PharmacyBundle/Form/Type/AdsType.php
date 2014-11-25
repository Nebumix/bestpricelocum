<?php

namespace Acme\PharmacyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdsType extends AbstractType
{


    const Personal_Insurance = 'Personal Insurance';
    const Medicine_Use_Review = 'Medicine Use Review';
    const Repeat_Dispensing = 'Repeat Dispensing';
    const New_Medicine_Service = 'New Medicine Service';
    const Stop_Smoking = 'Stop Smoking';
    const Emergency_Contraception = 'Emergency Contraception';
    const Flu_Jab = 'Flu Jab';
    const Minor_Ailment = 'Minor Ailment';
    const Reference = 'Reference';
    const Address_Proof = 'Address Proof';
    const Criminal_Record = 'Criminal Record';

    /*protected $user;  

    public function __construct($user)
    {
        $this->user = $user;
    }*/


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $options_id = $options['id'];

        $builder
            ->add('pharmacy', 'entity', array(
                'class' => 'AcmePharmacyBundle:Pharmacy',
                'query_builder' => function(EntityRepository $er) use($options_id) {
                    return $er->createQueryBuilder('u')
                        ->select('u')
                        ->where('u.idUser = ?1')
                        ->orderBy('u.name', 'ASC')
                        ->setParameter(1, $options_id );
                },
                'expanded' => true,
                'multiple' => false,
                'property' => 'name'
            ))
            ->add('roles', 'choice', array(
                'choices'   => array(
                'Hospital Pharmacist' => 'Hospital Pharmacist', 
                'Pharmacist' => 'Pharmacist', 
                'Pharmacist Technician' => 'Pharmacist Technician', 
                'PNG' => 'PNG', 
                'Dispenser' => 'Dispenser'),
                'required'  => true,
                'multiple' => false,
                'expanded' => true
            ))              
            ->add('price', 'money', array('max_length' => 6, 'currency' => 'GBP'))
            ->add('datejob', 'genemu_jquerydate')
            ->add('datejob', 'genemu_jquerydate', array(
                'widget' => 'single_text'
            ))      
            ->add('startshift', 'time', array(
                'input'  => 'datetime',
                'widget' => 'single_text',
                'required'  => true
            ))
            ->add('endshift', 'time', array(
                'input'  => 'datetime',
                'widget' => 'single_text',
                'required'  => true
            ))
            ->add('break', 'choice', array(
                'choices'   => array(true => 'Yes, there will be a break', false => 'No, there will not be a break'),
                'required'  => true,
                'empty_value' => '---',
                'empty_data'  => null,
            ))
            ->add('timebreak', 'choice', array(
                'choices'   => array('half' => 'Half hour', 'one' => 'One hour'),
                'required'  => false,
                'empty_value' => '---',
                'empty_data'  => null,
            ))  
            ->add('insurance', 'checkbox', array(
                'label'     => 'You need private insurance',
                'required'  => false,
            ))  
            ->add('criminal', 'checkbox', array(
                'label'     => 'You need criminal record',
                'required'  => false,
            )) 
            ->add('boots', 'checkbox', array(
                'label'     => 'You need boots training',
                'required'  => false,
            ))          
            ->add('reference', 'checkbox', array(
                'label'     => 'You need references',
                'required'  => false,
            ))  
            ->add('addressproof', 'checkbox', array(
                'label'     => 'You need address proof',
                'required'  => false,
            ))                             
            ->add('refound', 'textarea', array('required'  => false))
            ->add('carpark', 'choice', array(
                'choices'   => array('Free' => 'Free', 'For a fee' => 'For a fee'),
                'required'  => true,
                'empty_value' => '---',
                'empty_data'  => null,
            ))              
            ->add('op', 'text')
            ->add('support', 'checkbox', array(
                'label'     => 'There will be a support from the staff?',
                'required'  => false,
            ))    
            ->add('services', 'choice', array(
                'choices'   => array(self::Medicine_Use_Review => self::Medicine_Use_Review, 
                self::Repeat_Dispensing => self::Repeat_Dispensing, 
                self::New_Medicine_Service => self::New_Medicine_Service, 
                self::Stop_Smoking => self::Stop_Smoking,
                self::Emergency_Contraception => self::Emergency_Contraception,
                self::Flu_Jab => self::Flu_Jab, 
                self::Minor_Ailment => self::Minor_Ailment
                ),
                'empty_value' => 'choose a type',
                'empty_data'  => null,
                'required'  => true,
                'multiple' => true,
                'expanded' => true              
            ))              
            ->add('info', 'textarea', array('required'  => false));

    }

    public function getName()
    {
        return 'ad';
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\PharmacyBundle\Entity\Ads',
            'id' => null
        ));
    }



}
