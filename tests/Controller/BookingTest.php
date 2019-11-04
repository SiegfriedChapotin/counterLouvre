<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingTest extends WebTestCase

{
    public function testBookingForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');


        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Étape 1")')->count());

        $form = $crawler->selectButton('Etape suivante')->form();

        $form['booking[entry]']='12-12-2020';
        $form['booking[period]']= '1';
        $form['booking[numberTicket]']= 1;
        $form['booking[email][first]']='maurice.thorez@placerouge.com';
        $form['booking[email][second]']='maurice.thorez@placerouge.com';

        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect('/tickets'));
        $crawler = $client->followRedirect();

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Coordonnées")')->count());

        $Tickets = $crawler->selectButton('Etape suivante')->form();

        $Tickets['tickets[tickets][0][name]']='Thorez';
        $Tickets['tickets[tickets][0][firstname]']='Maurice';
        $Tickets['tickets[tickets][0][birthday][day]']=18;
        $Tickets['tickets[tickets][0][birthday][month]']=10;
        $Tickets['tickets[tickets][0][birthday][year]']=1920;
        $Tickets['tickets[tickets][0][nationality]']='FR';
        $Tickets['tickets[tickets][0][reduced]']=1;

        $crawler = $client->submit($Tickets);

        $this->assertTrue($client->getResponse()->isRedirect('/order'));

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Commande")')->count());


        $link = $crawler->selectLink('Paiement')->link();

        $crawler = $client->click($link);

        $this->assertSame(1, $crawler->filter('html:contains("Réglement")')->count());

        $this->assertTrue($client->getResponse()->isSuccessful());

    }
}
