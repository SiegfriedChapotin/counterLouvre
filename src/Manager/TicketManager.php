<?php


namespace App\Manager;


use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;

class TicketManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveTickets($tickets)
    {
        foreach ($tickets as $ticket) {
            $this->em->persist($ticket);
        }

        $this->em->flush();
    }

    public function updateTicketPrice(Ticket $ticket)
    {
        $age = $ticket->getBirthday()->diff(new \DateTime())->y;

        if ($age < 4) {
            $ticket->setPrice(0);
        } else if ($age < 11) {
            $ticket->setPrice(8);
        } else if ($age > 60) {
            $ticket->setPrice(12);
        } else {
            $ticket->setPrice(16);
        }
    }
}