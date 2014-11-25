<?php

namespace Acme\PharmacyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="farmacy")
 */
class Pharmacy
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
	 *  
     */
    protected $id;
	
	
    /**
     * @ORM\Column(type="integer")
     *
     */
    protected $idUser;
	
    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(message="Please enter the shop's name.")
     * @Assert\Length(
     *      max = "100"
     * ) 
	 * 
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     *
     * 
     */
    protected $state_id;	
	
    /**
     * @ORM\ManyToOne(targetEntity="States")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     *
     * 
     */
    protected $country_id;	

    /**
     * @ORM\ManyToOne(targetEntity="Countries")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    /**
	 * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(message="Please enter the name of city.")
     * @Assert\Length(
     *      max = "100"
     * )	  
     * @Assert\NotEqualTo(
     *     value = "Enter the pharmacy city. (e.g. London)",
	 * 	   message="Please enter the shop's city."
     * )	
	 * 
     */
    protected $city;	
	
	
    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Assert\NotBlank(message="Please enter the shop's postcode.")
     * @Assert\NotEqualTo(
     *     value = "Enter the pharmacy postcode. (e.g. W1D 1LL)",
	 * 	   message="Please enter the shop's postcode."
     * )
     * @Assert\Length(
     *      max = "10"
     * )	  
     * Assert\Regex(
     *     pattern="/^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/",
     *     message="Postcode not valid."
     * )    
	 *  
	 * 
	 */
    protected $postcode;


    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(message="Please enter address of shop.")
     * @Assert\Length(
     *      max = "100"
     * )	 
     * @Assert\NotEqualTo(
     *     value = "Enter the pharmacy address. (e.g. 100 Oxford Street)",
	 * 	   message="Please enter the shop's address."
     * )
	 * 
	 *  
     */
    protected $address;	

    /**
	 * @ORM\Column(type="string", length=10)
     *
     * @Assert\NotBlank(message="Please enter the GPhC registration number.")
     * @Assert\Length(
     *      max = "10"
     * )	
     * @Assert\Regex(
     *     pattern="/\d/",
     *     message="Please, enter just numbers"
     * )  
	 * 
     */
    protected $gphc;	
    
    
    /**
     * @ORM\Column(type="decimal", scale=5)
	 *  
	 * 
     */
    protected $lon;

    /**
     * @ORM\Column(type="decimal", scale=5)
	 *  
	 * 
     */
    protected $lat;		


    /**
     * @ORM\ManyToOne(targetEntity="\Acme\UserBundle\Entity\User", inversedBy="pharmacies", cascade={"persist"})
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Ads", mappedBy="pharmacy")
     **/
    private $ads;

    public function __construct() {
        $this->ads = new ArrayCollection();
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
     * Set idUser
     *
     * @param integer $idUser
     * @return Pharmacy
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
     * Set name
     *
     * @param string $name
     * @return Pharmacy
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set state_id
     *
     * @param integer $stateId
     * @return Pharmacy
     */
    public function setStateId($stateId)
    {
        $this->state_id = $stateId;

        return $this;
    }

    /**
     * Get state_id
     *
     * @return integer 
     */
    public function getStateId()
    {
        return $this->state_id;
    }

    /**
     * Set country_id
     *
     * @param integer $countryId
     * @return Pharmacy
     */
    public function setCountryId($countryId)
    {
        $this->country_id = $countryId;

        return $this;
    }

    /**
     * Get country_id
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Pharmacy
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Pharmacy
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Pharmacy
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set gphc
     *
     * @param string $gphc
     * @return Pharmacy
     */
    public function setGphc($gphc)
    {
        $this->gphc = $gphc;

        return $this;
    }

    /**
     * Get gphc
     *
     * @return string 
     */
    public function getGphc()
    {
        return $this->gphc;
    }

    /**
     * Set lon
     *
     * @param string $lon
     * @return Pharmacy
     */
    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * Get lon
     *
     * @return string 
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return Pharmacy
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set state
     *
     * @param \Acme\PharmacyBundle\Entity\States $state
     * @return Pharmacy
     */
    public function setState(\Acme\PharmacyBundle\Entity\States $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Acme\PharmacyBundle\Entity\States 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param \Acme\PharmacyBundle\Entity\Countries $country
     * @return Pharmacy
     */
    public function setCountry(\Acme\PharmacyBundle\Entity\Countries $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Acme\PharmacyBundle\Entity\Countries 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return Pharmacy
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

    /**
     * Get coord
     *
     * @return object
     */
    public function getCoord($string)
    {

        $str = str_replace(" ", "+", $string);

        $data = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$str.'&sensor=false&key=AIzaSyArbTtEoWFyFmdWSPlG0H3wQIg5CiElXeI');

        $dataObj = json_decode($data);

        return $dataObj;
    }


    /**
     * Add ads
     *
     * @param \Acme\PharmacyBundle\Entity\Ads $ads
     * @return Pharmacy
     */
    public function addAd(\Acme\PharmacyBundle\Entity\Ads $ads)
    {
        $this->ads[] = $ads;

        return $this;
    }

    /**
     * Remove ads
     *
     * @param \Acme\PharmacyBundle\Entity\Ads $ads
     */
    public function removeAd(\Acme\PharmacyBundle\Entity\Ads $ads)
    {
        $this->ads->removeElement($ads);
    }

    /**
     * Get ads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAds()
    {
        return $this->ads;
    }
}
