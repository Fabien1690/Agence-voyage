<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Circuit;
use phpDocumentor\Reflection\Types\Null_;
use App\Entity\ProgrammationCircuit;

class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/home", name="frontoffice_home")
     */
    public function index()
    {
        $circuits=$this->getDoctrine()->getManager()->getRepository(Circuit::class)->findAll();
        dump($circuits);
        
        return $this->render('front/home.html.twig', [
            'circuits'=> $circuits,
        ]);
    }
    
    /**
     * Finds and displays a circuit entity.
     *
     * @Route("/circuit/{id}", name="front_circuit_show")
     */
    public function circuitShow(Circuit $circuit)
    {
//         $em = $this->getDoctrine()->getManager();
        
//         $circuit = $em->getRepository(Circuit::class)->find($id);
        
        dump($circuit);
        
        return $this->render('front/circuit_show.html.twig', [
            'circuit' => $circuit,
        ]);
  
    }
    
    
    
    /**
     * @Route("/prog", name="circuitsprogrammes") //correspond à la page /prog
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function circuitProgrammes() {
        
        $circuits=$this->getDoctrine()->getManager()->getRepository(Circuit::class)->findAll();
        $programmes = array();

        foreach ($circuits as $circuit) {

            $prog = $circuit->getProgrammationCircuits();

            if (count($prog) > 0)
                $programmes[] = $circuit;
            
        }

        return $this->render('front/circuit_prog.html.twig', ['progs' => $programmes,]);
    }
    
    
    
    
    /**
     * @Route("/like/{id}", name="like")
     * 
     * @param int $id 
     */
    public function switchLikeCircuit($id){            
        $likes = $this->get('session')->get('likes');
        //$likes=null;
        
        if ($likes==null){
            $likes=[];
        }
        
        // si l'identifiant n'est pas présent dans le tableau des likes, l'ajouter
        if (! in_array(array($id), $likes)) {
            $likes[] = $id;   
        }
        else // sinon, le retirer du tableau
        {
             $likes = array_diff($likes, array($id)); //array_diff ne marche pas pour une raison inconnue...
             //unset($likes[array_search($id, $likes)]);
             
        }

        dump($likes);
   
        $this->get('session')->set('likes', $likes);

        return $this->redirectToRoute('front_circuit_show',array('id' => $id) );
        
        
    }
    
}
