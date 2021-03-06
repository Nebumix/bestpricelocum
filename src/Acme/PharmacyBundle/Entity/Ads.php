<?php

namespace Acme\PharmacyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ads")
 */
class Ads
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="integer")
     */
    private $idUser;

    /**
     * @ORM\Column(type="integer")
     *
	 * 
     */
    protected $idPharmacy;	
	
    /**
     * @ORM\Column(type="decimal", scale=2)
	 * 
     */
    protected $price;
	
    /**
	 * 
     * @ORM\Column(type="datetime")
	 * 
	 *
     */
    protected $datejob;	
	
    /**
	 * 
     * @ORM\Column(type="datetime")
	 * 
	 *
     */
    protected $startshift;		

    /**
	 * 
     * @ORM\Column(type="datetime")
	 * 
	 *
     */
    protected $endshift;			

    /**
	 * 
     * @ORM\Column(type="boolean")
	 * 
	 *
     *
     */
    protected $break;		
	
    /**
	 * 
     * @ORM\Column(type="string", length=50, nullable=true)
	 * 
	 *
     * 
     */
    protected $timebreak;				

    /**
	 * 
     * @ORM\Column(type="datetime")
	 * 
	 *
     */
    protected $dateinsert;	 
       
    /**
	 * 
     * @ORM\Column(type="boolean")
	 * 
     */
    protected $active;	    
	
    /**
	 * 
     * @ORM\Column(type="boolean")
	 * 
     */
    protected $published;	 	

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="array", nullable=true)
     *
     */
    private $roles;    

    /**
     * @var boolean
     *
     * @ORM\Column(name="insurance", type="boolean", nullable=true)
     */
    private $insurance;
	
    /**
     * @var boolean
     *
     * @ORM\Column(name="criminal", type="boolean", nullable=true)
     */
    private $criminal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="boots", type="boolean", nullable=true)
     */
    private $boots;
	
    /**
     * @var string
     *
     * @ORM\Column(name="refound", type="text", nullable=true)
     */
    private $refound;

    /**
	 * 
     * @ORM\Column(type="string", length=10)
     */
    protected $carpark;		
	
    /**
	 * 
     * @ORM\Column(type="string", length=100)
     */
    protected $op;	
	
    /**
     * @var boolean
     *
     * @ORM\Column(name="support", type="boolean", nullable=true)
     */
    private $support;			

    /**
     * @var boolean
     *
     * @ORM\Column(name="reference", type="boolean", nullable=true)
     */
    private $reference;	

    /**
     * @var boolean
     *
     * @ORM\Column(name="addressproof", type="boolean", nullable=true)
     */
    private $addressproof;	

    /**
     * @var string
     *
     * @ORM\Column(name="services", type="array", nullable=true)
     */
    private $services;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;

    /**
     * @ORM\ManyToOne(targetEntity="Pharmacy", inversedBy="ads", cascade={"all"})
     * @ORM\JoinColumn(name="idPharmacy", referencedColumnName="id")
     */
    private $pharmacy;   

    /**
     * @ORM\ManyToOne(targetEntity="\Acme\UserBundle\Entity\User", inversedBy="ads", cascade={"persist"})
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     */
    private $user;

    /**
     * @Assert\True(message = "Please, select the time of break")
     */
    public function isTimebreakValid()
    {
    	if($this->break){
    					
    		if(trim($this->timebreak) != NULL){
    			return true;
    		}else{
    			return false;
    		}	
    			
    	}else{
    		return true;
    	}
				
    }   
	
    /**
     * @Assert\True(message = "Please, select the right time of start and the right time of end.")
     */
    public function isTimestartendValid()
    {
				
		if($this->startshift->format('H') > $this->endshift->format('H')){
			return false;
		}elseif($this->startshift->format('H') < $this->endshift->format('H')){
			return true;
		}elseif($this->startshift->format('H') == $this->endshift->format('H')){
			if($this->startshift->format('i') >= $this->endshift->format('i')){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
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
     * Set idPharmacy
     *
     * @param integer $idPharmacy
     * @return Ads
     */
    public function setIdPharmacy($idPharmacy)
    {
        $this->idPharmacy = $idPharmacy;

        return $this;
    }

    /**
     * Get idPharmacy
     *
     * @return integer 
     */
    public function getIdPharmacy()
    {
        return $this->idPharmacy;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Ads
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set datejob
     *
     * @param \DateTime $datejob
     * @return Ads
     */
    public function setDatejob($datejob)
    {
        $this->datejob = $datejob;

        return $this;
    }

    /**
     * Get datejob
     *
     * @return \DateTime 
     */
    public function getDatejob()
    {
        return $this->datejob;
    }

    /**
     * Set startshift
     *
     * @param \DateTime $startshift
     * @return Ads
     */
    public function setStartshift($startshift)
    {
        $this->startshift = $startshift;

        return $this;
    }

    /**
     * Get startshift
     *
     * @return \DateTime 
     */
    public function getStartshift()
    {
        return $this->startshift;
    }

    /**
     * Set endshift
     *
     * @param \DateTime $endshift
     * @return Ads
     */
    public function setEndshift($endshift)
    {
        $this->endshift = $endshift;

        return $this;
    }

    /**
     * Get endshift
     *
     * @return \DateTime 
     */
    public function getEndshift()
    {
        return $this->endshift;
    }

    /**
     * Set break
     *
     * @param boolean $break
     * @return Ads
     */
    public function setBreak($break)
    {
        $this->break = $break;

        return $this;
    }

    /**
     * Get break
     *
     * @return boolean 
     */
    public function getBreak()
    {
        return $this->break;
    }

    /**
     * Set timebreak
     *
     * @param string $timebreak
     * @return Ads
     */
    public function setTimebreak($timebreak)
    {
        $this->timebreak = $timebreak;

        return $this;
    }

    /**
     * Get timebreak
     *
     * @return string 
     */
    public function getTimebreak()
    {
        return $this->timebreak;
    }

    /**
     * Set dateinsert
     *
     * @param \DateTime $dateinsert
     * @return Ads
     */
    public function setDateinsert($dateinsert)
    {
        $this->dateinsert = $dateinsert;

        return $this;
    }

    /**
     * Get dateinsert
     *
     * @return \DateTime 
     */
    public function getDateinsert()
    {
        return $this->dateinsert;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Ads
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Ads
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return Ads
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set insurance
     *
     * @param boolean $insurance
     * @return Ads
     */
    public function setInsurance($insurance)
    {
        $this->insurance = $insurance;

        return $this;
    }

    /**
     * Get insurance
     *
     * @return boolean 
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * Set criminal
     *
     * @param boolean $criminal
     * @return Ads
     */
    public function setCriminal($criminal)
    {
        $this->criminal = $criminal;

        return $this;
    }

    /**
     * Get criminal
     *
     * @return boolean 
     */
    public function getCriminal()
    {
        return $this->criminal;
    }

    /**
     * Set boots
     *
     * @param boolean $boots
     * @return Ads
     */
    public function setBoots($boots)
    {
        $this->boots = $boots;

        return $this;
    }

    /**
     * Get boots
     *
     * @return boolean 
     */
    public function getBoots()
    {
        return $this->boots;
    }

    /**
     * Set refound
     *
     * @param string $refound
     * @return Ads
     */
    public function setRefound($refound)
    {
        $this->refound = $refound;

        return $this;
    }

    /**
     * Get refound
     *
     * @return string 
     */
    public function getRefound()
    {
        return $this->refound;
    }

    /**
     * Set carpark
     *
     * @param string $carpark
     * @return Ads
     */
    public function setCarpark($carpark)
    {
        $this->carpark = $carpark;

        return $this;
    }

    /**
     * Get carpark
     *
     * @return string 
     */
    public function getCarpark()
    {
        return $this->carpark;
    }

    /**
     * Set op
     *
     * @param string $op
     * @return Ads
     */
    public function setOp($op)
    {
        $this->op = $op;

        return $this;
    }

    /**
     * Get op
     *
     * @return string 
     */
    public function getOp()
    {
        return $this->op;
    }

    /**
     * Set support
     *
     * @param boolean $support
     * @return Ads
     */
    public function setSupport($support)
    {
        $this->support = $support;

        return $this;
    }

    /**
     * Get support
     *
     * @return boolean 
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Set reference
     *
     * @param boolean $reference
     * @return Ads
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return boolean 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set addressproof
     *
     * @param boolean $addressproof
     * @return Ads
     */
    public function setAddressproof($addressproof)
    {
        $this->addressproof = $addressproof;

        return $this;
    }

    /**
     * Get addressproof
     *
     * @return boolean 
     */
    public function getAddressproof()
    {
        return $this->addressproof;
    }

    /**
     * Set services
     *
     * @param array $services
     * @return Ads
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Get services
     *
     * @return array 
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set info
     *
     * @param string $info
     * @return Ads
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set pharmacy
     *
     * @param \Acme\PharmacyBundle\Entity\Pharmacy $pharmacy
     * @return Ads
     */
    public function setPharmacy(\Acme\PharmacyBundle\Entity\Pharmacy $pharmacy = null)
    {
        $this->pharmacy = $pharmacy;

        return $this;
    }

    /**
     * Get pharmacy
     *
     * @return \Acme\PharmacyBundle\Entity\Pharmacy 
     */
    public function getPharmacy()
    {
        return $this->pharmacy;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     * @return Ads
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return Ads
     */
    public function setUser(\Acme\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
