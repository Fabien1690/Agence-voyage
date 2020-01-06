<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ProgrammationCircuit;

class LoadProgrammationCircuitData extends Fixture
{
	public function load(ObjectManager $manager)
	{
	    $programmationCircuit=new ProgrammationCircuit();
	    $programmationCircuit->setDateDepart(new \DateTime("2015-05-12"));
	    $programmationCircuit->setNombrePersonnes(25);
	    $programmationCircuit->setPrix(68);
	    
	    
	    $circuit = $this->getReference('andalousie-circuit');
	    
	    
	    //$programmationCircuit->setCircuit($circuit);
	    
	    $circuit->addProgrammationCircuit ($programmationCircuit);
	    
	    $this->addReference('andalousie-programmation', $programmationCircuit);
	    
	    $manager->persist($programmationCircuit);
	    $manager->persist($circuit);
	    
		
		
		
		
		$manager->flush();
	}
	
}