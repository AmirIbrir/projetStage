<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContactTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Labela Business');

        // Récupérer le formulaire
        $submitButton = $crawler->selectButton('Send Message');
        $form = $submitButton->form();
        $form["visitor_message[fullName]"] = "Alexandre Meye";
        $form["visitor_message[email]"] = "visitor11@gmail.com";
        $form["visitor_message[subject]"] = "test";
        $form["visitor_message[messageContent]"] = "test";

        // Soumettre le formulaire
        $client->submit($form);
        // Vérifier le statut HTTP
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        // Vérifier l'envoie du mail
        $this->assertEmailCount(1);
        $client->followRedirect();
        // Vérifier la présence du message de succes
        $this->assertSelectorTextContains(
            'div.alert.alert-succes.mt-4',
            'Votre demande a ete envoyé avec succes !'
        );
    }
}
