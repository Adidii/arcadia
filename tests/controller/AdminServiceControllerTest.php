<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminServiceControllerTest extends WebTestCase
{
    public function testNewServicePageLoads(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/service/new');

        // Vérifie que la page se charge avec succès
        $this->assertResponseIsSuccessful();

        // Vérifie que le formulaire est présent sur la page
        $this->assertSelectorExists('form');

        // Vérifie que le bouton du formulaire existe
        $this->assertSelectorTextContains('button', 'Ajouter');
    }

    public function testSubmitValidForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/service/new');

        $form = $crawler->selectButton('Ajouter')->form([
            'service[name]' => 'Service Test',
            'service[description]' => 'Ceci est un service de test.',
        ]);

        $client->submit($form);

        // Vérifie que la redirection a bien eu lieu
        $this->assertResponseRedirects('/services');

        // Suivre la redirection
        $client->followRedirect();

        // Vérifie qu'un message flash s'affiche
        $this->assertSelectorTextContains('.flash-success', 'Le service a été ajouté avec succès.');
    }
}
