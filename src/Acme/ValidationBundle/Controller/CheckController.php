<?php

namespace Acme\ValidationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nebumix\rtValidationBundle\Controller\CheckController as BaseController;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

class CheckController extends BaseController
{
    public function __construct()
    {

    }

    public function isTimebreakValidAction(Request $request)
    {
		$break = $request->request->get('item');
		$timebreak = $request->request->get('item1');

    	if($break == 1){
    					
    		if(trim($timebreak) != NULL){
    			return new Response('1');
    		}else{
    			return new Response('Please, select a time for break.');
    		}	
    			
    	}else{
    		return new Response('1');
    	}
    }   

    public function isTimestartendValidAction(Request $request)
    {
                
        $dS = $request->request->get('item');
        $dE = $request->request->get('item1');

        if( $dS != "" && $dE != ""){


            $startshift = new \DateTime($dS);
            $endshift = new \DateTime($dE);


            if($startshift->format('H') > $endshift->format('H')){
                return new Response('End of shift must be later than start of shift');
            }elseif($startshift->format('H') < $endshift->format('H')){
                return new Response('1');
            }elseif($startshift->format('H') == $endshift->format('H')){
                if($startshift->format('i') >= $endshift->format('i')){
                    return new Response('End of shift must be later than start of shift');
                }else{
                    return new Response('1');
                }
            }else{
                return new Response('End of shift must be later than start of shift');
            }


        }else{
            return new Response('-1');
        }
    }     

}
