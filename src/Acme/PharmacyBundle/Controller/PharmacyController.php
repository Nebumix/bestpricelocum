<?php
namespace Acme\PharmacyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*use Acme\FarmacyBundle\Entity\Farmacy;
use Acme\FarmacyBundle\Entity\Ads;
use Acme\FarmacyBundle\Entity\Customer;
use Acme\FarmacyBundle\Entity\Document;
use Acme\FarmacyBundle\Entity\Offers;
use Acme\FarmacyBundle\Entity\Contracts;
use Acme\FarmacyBundle\Entity\Feedbacktotalpharmacy;
use Acme\FarmacyBundle\Entity\Feedbacktotal;
use Acme\FarmacyBundle\Entity\Feedbackpharmacy;
use Acme\FarmacyBundle\Entity\Feedback;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

*/
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\InfoWindow;
use Ivory\GoogleMap\Events\MouseEvent;
use Ivory\GoogleMap\Controls\ControlPosition;
use Ivory\GoogleMap\Controls\MapTypeControl;
use Ivory\GoogleMap\Controls\MapTypeControlStyle;
use Ivory\GoogleMap\Controls\PanControl;
use Ivory\GoogleMap\Controls\ScaleControl;
use Ivory\GoogleMap\Controls\ScaleControlStyle;
use Ivory\GoogleMap\Controls\StreetViewControl;
use Ivory\GoogleMap\Controls\ZoomControl;
use Ivory\GoogleMap\Controls\ZoomControlStyle;
/*
use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;*/


class PharmacyController extends Controller
{
	
	protected $lon;
	
	protected $lat;
	
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
	
	
	
	
    public function indexAction()
    {
    	
		if($this->getUser()){
		
			if(in_array("ROLE_EMPLOYER", $this->getUser()->getRoles())){
				
				
				$check = $this->checkFarmacyAction();

				return $this->render('AcmePharmacyBundle:Employer:indexEmployer.html.twig', array('check' => $check));
				

			}elseif(in_array("ROLE_FREELANCER", $this->getUser()->getRoles())){
				
				
				$em = $this->getDoctrine()->getManager();
						
				$query = $em->createQuery(
				    'SELECT count(o.id)
				    FROM AcmeFarmacyBundle:Offers o, 
			         AcmeFarmacyBundle:Ads a 
					 WHERE a.id = o.idad 
					 AND o.idowner = :idowner 
					 AND DATEDIFF(a.datejob, CURRENT_DATE()) >= 1' 
				)->setParameter('idowner', $this->getUser()->getId());
				
				$noffers = $query->getSingleScalarResult();	




				return $this->render('AcmePharmacyBundle:Customer:indexNotEmployer.html.twig', array(
            		'noffers' => $noffers,
        		));



			}else{

			        return $this->render('AcmePharmacyBundle:Default:index.html.twig');

			}






		}else{
			//return $this->render('AcmePharmacyBundle:Farmacy:index.html.twig');		
			        return $this->render('AcmePharmacyBundle:Default:index.html.twig');
	
		}

    }

	/*
	 * Controlla che l'utente abbia gia creato almeno una farmacia.
	 * Se l'utente non ha farmacie non può inserire annunci.
	 * 
	 */
	//CONDIVISO 
    protected function checkFarmacyAction()
    {
	    $pharmacy = $this->getDoctrine()
	        ->getRepository('AcmePharmacyBundle:Pharmacy')
	        ->findByIdUser($this->getUser()->getId());

	    if (!$pharmacy) {
			return false;			
	    }else{
			return true;
	    }		
    }		


    public function showmapAction($id)
    {

	    $product = $this->getDoctrine()
	        ->getRepository('AcmePharmacyBundle:Pharmacy')
	        ->find($id);
	
	    if (!$product) {
	        throw $this->createNotFoundException(
	            'Nessun prodotto trovato per l\'id '.$id
	        );
	    }

		$map = new Map();
		
		$map->setPrefixJavascriptVariable('map_');
		$map->setHtmlContainerId('map_canvas');
		
		$map->setAsync(false);
		$map->setAutoZoom(false);
		
		$map->setCenter($product->getLat(), $product->getLon(), true);
		$map->setMapOption('zoom', 15);
		
		$map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);
		
		$map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
		$map->setMapOption('mapTypeId', 'roadmap');
		
		$map->setMapOption('disableDefaultUI', true);
		$map->setMapOption('disableDoubleClickZoom', true);
		$map->setMapOptions(array(
		    'disableDefaultUI'       => true,
		    'disableDoubleClickZoom' => true,
		));
		
		$map->setStylesheetOption('width', '300px');
		$map->setStylesheetOption('height', '300px');
		$map->setStylesheetOptions(array(
		    'width'  => '550px',
		    'height' => '380px',
		));
		
		$map->setLanguage('en');



		$marker = new Marker();
		
		// Configure your marker options
		$marker->setPrefixJavascriptVariable('marker_');
		$marker->setPosition($product->getLat(), $product->getLon(), true);
		$marker->setAnimation(Animation::DROP);
		
		$marker->setOption('clickable', false);
		$marker->setOption('flat', true);
		$marker->setOptions(array(
		    'clickable' => true,
		    'flat'      => true,
		));

		$marker->setAnimation(Animation::BOUNCE);
		$marker->setAnimation('bounce');
		
		$marker->setAnimation(Animation::DROP);
		$marker->setAnimation('drop');

		$map->addMarker($marker);




		$infoWindow = new InfoWindow();
		
		// Configure your info window options
		$infoWindow->setPrefixJavascriptVariable('info_window_');
		$infoWindow->setPosition($product->getLat(), $product->getLon(), true);
		$infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
		$infoWindow->setContent($product->getName().'<br>'.$product->getAddress().' '.$product->getPostcode());
		$infoWindow->setOpen(true);
		$infoWindow->setAutoOpen(true);
		$infoWindow->setOpenEvent(MouseEvent::CLICK);
		$infoWindow->setAutoClose(true);
		$infoWindow->setOption('disableAutoPan', true);
		$infoWindow->setOption('zIndex', 10);
		$infoWindow->setOptions(array(
		    'disableAutoPan' => true,
		    'zIndex'         => 10,
		));
		
		$marker->setInfoWindow($infoWindow);		
		
		$map->addInfoWindow($infoWindow);		
		


		$mapTypeControl = new MapTypeControl();
		
		// Configure your map type control
		$mapTypeControl->setMapTypeIds(array(MapTypeId::ROADMAP, MapTypeId::SATELLITE));
		
		$mapTypeControl->addMapTypeId(MapTypeId::ROADMAP);
		$mapTypeControl->addMapTypeId(MapTypeId::SATELLITE);
		
		$mapTypeControl->setControlPosition(ControlPosition::TOP_RIGHT);
		
		$mapTypeControl->setMapTypeControlStyle(MapTypeControlStyle::DEFAULT_);


		$map->setMapTypeControl($mapTypeControl);



		$panControl = new PanControl();
		
		// Configure your pan control
		$panControl->setControlPosition(ControlPosition::TOP_LEFT);
		

		$map->setPanControl($panControl);
		
		
		
		
		$scaleControl = new ScaleControl();
		
		// Configure your scale control
		$scaleControl->setControlPosition(ControlPosition::BOTTOM_LEFT);
		$scaleControl->setScaleControlStyle(ScaleControlStyle::DEFAULT_);		
				
		$map->setScaleControl($scaleControl);



		$streetViewControl = new StreetViewControl();
		
		// Configure your street view control
		$streetViewControl->setControlPosition(ControlPosition::TOP_LEFT);
		
		$map->setStreetViewControl($streetViewControl);


		$zoomControl = new ZoomControl();
		
		// Configure your zoom control
		$zoomControl->setControlPosition(ControlPosition::TOP_LEFT);
		$zoomControl->setZoomControlStyle(ZoomControlStyle::DEFAULT_);
		
		$map->setZoomControl($zoomControl);		
		

        return $this->render('AcmePharmacyBundle:Pharmacy:showMap.html.twig', array(
            'map' => $map
        )); 
    }		








}
