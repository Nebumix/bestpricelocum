<?php

namespace Acme\PharmacyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\PharmacyBundle\Entity\Pharmacy;

use Acme\PharmacyBundle\Controller\PharmacyController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;


use Acme\PharmacyBundle\Form\Type\PharmacyType;
use Acme\PharmacyBundle\Form\Type\AdsType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Acme\PharmacyBundle\Entity\Ads;
/*use Acme\FarmacyBundle\Entity\Customer;
use Acme\FarmacyBundle\Entity\Document;
use Acme\FarmacyBundle\Entity\Offers;
use Acme\FarmacyBundle\Entity\Contracts;
use Acme\FarmacyBundle\Entity\Feedbacktotalpharmacy;
use Acme\FarmacyBundle\Entity\Feedbacktotal;
use Acme\FarmacyBundle\Entity\Feedbackpharmacy;
use Acme\FarmacyBundle\Entity\Feedback;
use Acme\FarmacyBundle\Entity\NumberGPhC;




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

use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;*/

class EmployerController extends PharmacyController
{


	/*
	 * Controlla che l'utente sia un employer, se non lo è rimanda tutto alla pagina iniziale.
	 * 
	 */
    private function checkEmployerAction()
    {		
		if(!$this->getUser()->getEmployer()){
			return true;
		}
	}

    public function addFarmacyAction()
    {
    	/*if($this->checkEmployerAction()){
			return $this->redirect($this->generateUrl('_Welcome'));
    	}*/
		
        $pharmacy = new Pharmacy();
        /*$pharmacy->setState(1);
        $pharmacy->setCountry(1);*/
		
		$form = $this->createForm(new PharmacyType(), $pharmacy);

        return $this->render('AcmePharmacyBundle:Employer:addPharmacy.html.twig', array(
            'form' => $form->createView(),
        ));
    }	

    public function saveFarmacyAction(Request $request)
    {
    	/*if($this->checkEmployerAction()){
			return $this->redirect($this->generateUrl('_Welcome'));
    	}*/
		
        $pharmacy = new Pharmacy();
        /*$pharmacy->setState(1);
        $pharmacy->setCountry(1);		*/

		$form = $this->createForm(new PharmacyType(), $pharmacy);

	    $form->handleRequest($request);
	
	    if ($form->isValid()) {
	        
	        $em = $this->getDoctrine()->getManager();

			$this->getUser()->addPharmacy($pharmacy);
			$pharmacy->setUser($this->getUser());

			$str = $pharmacy->getAddress()." ".$pharmacy->getPostcode()." ".$pharmacy->getCity().", UK";
	        $dataObj = $pharmacy->getCoord($str);


	        if($dataObj->status == "ZERO_RESULTS" ){
	        	return new Response(-1);
	        }
	
			$pharmacy->setLon($dataObj->results[0]->geometry->location->lng);
			$pharmacy->setLat($dataObj->results[0]->geometry->location->lat);


		    $em->persist($pharmacy);
		    $em->flush();
	
	        return new Response(1);
	    }

        return new Response(0);

    }	

    public function listFarmaciesAction()
    {
		$repository = $this->getDoctrine()
		    ->getRepository('AcmePharmacyBundle:Pharmacy');

		$pharmacies = $repository->findByIdUser($this->getUser());


		if(!$pharmacies){
	        return $this->render('AcmePharmacyBundle:Employer:listPharmacies.html.twig');			
		}

        return $this->render('AcmePharmacyBundle:Employer:listPharmacies.html.twig', array(
            'pharmacies' => $pharmacies,
        ));
    }	

    public function checkAdAction($id)
    {
    	/*if($this->checkEmployerAction()){
			return $this->redirect($this->generateUrl('_Welcome'));
    	}*/

		$repository = $this->getDoctrine()
		    ->getRepository('AcmePharmacyBundle:Ads');
		
		$ads = $repository->findBy(
		    array('idPharmacy' => $id, 'idUser' => $this->getUser()->getId())
		);
	
	    if ($ads) {
			return new Response('0');			
	    }else{
			return new Response('1');			
	    }		
    }		

    public function delPharmacyAction($id)
    {
    	/*if($this->checkEmployerAction()){
			return $this->redirect($this->generateUrl('_Welcome'));
    	}*/
    	
	    $em = $this->getDoctrine()->getManager();
	    $pharmacy = $em->getRepository('AcmePharmacyBundle:Pharmacy')->find($id);			
		
		if($pharmacy){
			if($pharmacy->getIdUser() == $this->getUser()->getId()){
				$em->remove($pharmacy);
				$em->flush();
			}
		}

    	return $this->redirect($this->generateUrl('_List_farmacies'));
    }	

    public function addAdAction(Request $request)
    {
    	/*if($this->checkEmployerAction()){
			return $this->redirect($this->generateUrl('_Welcome'));
    	}*/
    	
    	$check = $this->checkFarmacyAction();
		//FARE QUALCOSA CON QUESTO CONTROLLO


		
		//echo date("Y-m-d H:i:s");

        $ad = new Ads();
        //$farmacy->setUser($this->getUser());
		$ad->setDateinsert(new \DateTime('now'));
		$ad->setActive(1);
		$ad->setPublished(0);

		$form = $this->createForm('ad', $ad, array('id' => $this->getUser()->getId()));
		
	    if ($form->isValid()) {

			$data = $form->getData();

			//$farmacy->setIdfarmacy($data['idfarmacy']->getId());
			$ad->setIdfarmacy($farmacy->getIdfarmacy()->getId());
	        
	        $em = $this->getDoctrine()->getManager();
		    $em->persist($ad);
		    $em->flush();
	
	        return $this->redirect($this->generateUrl('_Ads_list'));
	    }


        return $this->render('AcmePharmacyBundle:Employer:addAd.html.twig', array(
            'form' => $form->createView(), 'check' => $check
        ));
    }	

    public function saveAdAction(Request $request)
    {
    	/*if($this->checkEmployerAction()){
			return $this->redirect($this->generateUrl('_Welcome'));
    	}*/
		
        $ad = new Ads();
		$ad->setDateinsert(new \DateTime('now'));
		$ad->setActive(1);
		$ad->setPublished(0);
		//$form = $this->createForm(new AdsType(), $ad);
		$form = $this->createForm('ad', $ad, array('id' => $this->getUser()->getId()));


	    $form->handleRequest($request);
	
	    if ($form->isValid()) {
	        
	        $em = $this->getDoctrine()->getManager();

			$this->getUser()->addOrder($ad);
			$ad->setUser($this->getUser());

		    $em->persist($ad);
		    $em->flush();
	
	        return new Response(1);
	    }

        return new Response(0);

    }	

	/*
	 * Lista di tutti gli annunci inseriti.
	 * Per ogni annuncio è presente anche il numero di offerte ricevute.
	 * Da qui si va a vedere la lista delle offerte effettuate per ogni annuncio.
	 * 
	 */
    public function listAdsAction()
    {
    	/*if($this->checkEmployerAction()){
			return $this->redirect($this->generateUrl('_Welcome'));
    	}*/

    	if(!$check = $this->checkFarmacyAction()){
			return $this->render('AcmePharmacyBundle:Employer:adsList.html.twig', 
				array('check' => $check)
			);
    	}

		$repository = $this->getDoctrine()
		    ->getRepository('AcmePharmacyBundle:Ads');

		$query = $repository->createQueryBuilder('a')
		    ->where('a.idUser = :idUser')
		    ->andWhere('DATEDIFF(a.datejob, CURRENT_DATE()) >= 1')
		    ->setParameter('idUser', $this->getUser()->getId())
		    ->getQuery();

		$ads = $query->getResult();

	    if (!$ads) {
			return $this->render('AcmePharmacyBundle:Employer:adsList.html.twig', 
				array('check' => $check)
			);		
	    }

		return $this->render('AcmePharmacyBundle:Employer:adsList.html.twig', 
			array('ads' => $ads, 'check' => $check)
		);
			
    }

	/*
	 * Amministrazione di un annuncio.
	 * E' possibile vedere le specifiche dell'annuncio, tutte le offerte che sono state fatte, 
	 * vedere se il locum ha le caratteristiche adatte, i feedback, 
	 * si possono scremare le offerte e scegliere quella definitiva.
	 * 
	 */
    public function adminAdPageAction($id)
    {
/*    	if($this->checkEmployerAction()){
			return $this->redirect($this->generateUrl('_Welcome'));
    	}*/
		
	    $ad = $this->getDoctrine()
	        ->getRepository('AcmePharmacyBundle:Ads')
	        ->findOneBy(array('id' => $id, 'idUser' => $this->getUser()->getId()));


/*
		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
		    'SELECT a, f, c, s
		    FROM AcmeFarmacyBundle:Ads a, 
		    AcmeFarmacyBundle:Farmacy f, 
		    AcmeFarmacyBundle:Countries c, 
		    AcmeFarmacyBundle:States s
			WHERE a.idfarmacy = f.id
		    AND a.idowner = :idowner
		    AND a.id = :ida
		    AND f.state = s.id
		    AND f.country = c.id'
		)->setParameter('ida', $id)
		->setParameter('idowner', $this->getUser()->getId());
		
		$ad = $query->getResult();*/

	    if (!$ad) {
			return $this->render('AcmePharmacyBundle:Employer:adminAdPage.html.twig');			
		}



/*
		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
		    'SELECT o, co, c, f
		    FROM AcmeFarmacyBundle:Ads a, 
		    AcmeFarmacyBundle:Offers o, AcmeFarmacyBundle:Contracts co, 
		    AcmeFarmacyBundle:Customer c LEFT OUTER JOIN AcmeFarmacyBundle:Feedbacktotal f 
			 WITH c.id = f.idcustomer 
			WHERE a.id = o.idad
		    AND a.idowner = :idowner AND c.id = o.idowner
		    AND co.idad = a.id AND co.idoffer = o.id
		    AND a.id = :ida'
		)->setParameter('ida', $id)
		->setParameter('idowner', $this->getUser()->getId());
		
		$contract = $query->getResult();

	    if ($contract) {
	    	
	    	$n = $contract[3]->getStars();
			$intero = (int)$n;
			$resto = $n-$intero;
			if($resto <= 0.5){
				$nn = floor($n);
			}else{
				$nn = ceil($n);		
			}
			$contract[3]->setStars($nn);
			
			$per = (100*$contract[3]->getNfeedbackpos())/$contract[3]->getNfeedback();
			$contract[3]->setNfeedbackpos($per);			

			return $this->render('AcmeFarmacyBundle:Employer:adminadpage.html.twig', array(
	    		'contract' => $contract, 'ad' => $ad
			));	
		}		*/

/*		$em = $this->getDoctrine()->getManager();
				
		$query = $em->createQuery(
		    'SELECT c.id as idc, c.fname, c.sname, o.id as ido, o.price, o.stato, o.reply, 
		    f.nfeedback, f.nfeedbackpos, f.stars
		    FROM AcmeFarmacyBundle:Offers o, 
		    AcmeFarmacyBundle:Customer c LEFT OUTER JOIN AcmeFarmacyBundle:Feedbacktotal f 
			 WITH c.id = f.idcustomer 
			WHERE o.idowner = c.id AND o.idad = :idad ORDER BY o.reply asc'
		)->setParameter('idad', $id);


		$offers = $query->getResult();	

		for($i = 0; $i < count($offers); $i++){
	    	$n = $offers[$i]['stars'];
			$intero = (int)$n;
			$resto = $n-$intero;
			if($resto <= 0.5){
				$nn = floor($n);
			}else{
				$nn = ceil($n);		
			}
			$offers[$i]['stars'] = $nn;
			
			
			$per = (100*$offers[$i]['nfeedbackpos'])/$offers[$i]['nfeedback'];
			$offers[$i]['nfeedbackpos'] = $per;

		}*/

/*	    if (!$offers) {
			return $this->render('AcmeFarmacyBundle:Employer:adminadpage.html.twig', array(
	    		'ad' => $ad
			)); 
		}

		return $this->render('AcmeFarmacyBundle:Employer:adminadpage.html.twig', array(
    		'offers' => $offers, 'ad' => $ad
		));    */	


			return $this->render('AcmePharmacyBundle:Employer:adminAdPage.html.twig', array(
	    		'ad' => $ad
			)); 
	}

}