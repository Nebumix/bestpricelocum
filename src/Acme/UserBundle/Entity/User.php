<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     *
     * @Assert\NotBlank(message="Please enter your preference.", groups={"Registration", "Profile"})
     * 
     * 
     */
    protected $employer;
    
    /**
     * @ORM\OneToMany(targetEntity="\Acme\PharmacyBundle\Entity\Pharmacy", mappedBy="user", cascade={"persist", "remove", "merge"})
     */
    protected $pharmacies;

    /**
     * @ORM\OneToMany(targetEntity="\Acme\PharmacyBundle\Entity\Ads", mappedBy="user", cascade={"persist", "remove", "merge"})
     */
    protected $orders;


    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->pharmacies = new ArrayCollection();
        $this->orders = new ArrayCollection();

    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set employer
     *
     * @param boolean $employer
     * @return User
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;

        if($employer){
            parent::addRole('ROLE_EMPLOYER');
        }else{
            parent::addRole('ROLE_FREELANCER');
        }

        return $this;
    }

    /**
     * Get employer
     *
     * @return boolean 
     */
    public function getEmployer()
    {
        return $this->employer;
    }
    
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);
    }


    /**
     * Add pharmacies
     *
     * @param \Acme\PharmacyBundle\Entity\Pharmacy $pharmacies
     * @return User
     */
    public function addPharmacy(\Acme\PharmacyBundle\Entity\Pharmacy $pharmacies)
    {
        $this->pharmacies[] = $pharmacies;

        return $this;
    }

    /**
     * Remove pharmacies
     *
     * @param \Acme\PharmacyBundle\Entity\Pharmacy $pharmacies
     */
    public function removePharmacy(\Acme\PharmacyBundle\Entity\Pharmacy $pharmacies)
    {
        $this->pharmacies->removeElement($pharmacies);
    }

    /**
     * Get pharmacies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPharmacies()
    {
        return $this->pharmacies;
    }

    /**
     * Add orders
     *
     * @param \Acme\PharmacyBundle\Entity\Ads $orders
     * @return User
     */
    public function addOrder(\Acme\PharmacyBundle\Entity\Ads $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \Acme\PharmacyBundle\Entity\Ads $orders
     */
    public function removeOrder(\Acme\PharmacyBundle\Entity\Ads $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
