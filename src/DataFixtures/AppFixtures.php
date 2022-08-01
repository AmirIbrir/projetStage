<?php

namespace App\DataFixtures;

use App\Entity\VisitorsMessage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Generator;
use Symfony\Component\Mime\Message;

class AppFixtures extends Fixture

{
    
        
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i < 20 ; $i++) { 
            
            $message = new VisitorsMessage();

            $message->setFullName($faker->name);
            $message->setSubject($faker->sentence(5,false));
            $message->setMessageContent($faker->text);
            $message->setEmail('visitor'. $i.'@gmail.com');

            $manager->persist($message);
        }
        
        

        $manager->flush();
    }
}
