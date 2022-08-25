<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends WebTestCase
{
    public function testIfLoginSuccesFull(): void
    {
        $client = static::createClient();
        
        /** @var urlGeneratorInterface $urlGenerator */ 
         
        $urlGenerator = $client->getContainer()->get("router");
        $crawler = $client->request('GET', $urlGenerator->generate('security.login'));
        
        //form
        $form = $crawler->filter("form[name=login]")->form([
            "email" => "admin_2@admin.fr",
            "password" => "password"

        ]);

        $client->submit($form);


        //redirect + home
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertRouteSame('home.index');
    }
}
