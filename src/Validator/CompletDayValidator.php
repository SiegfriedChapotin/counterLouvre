<?php


namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Entity\Booking;
use App\Entity\Ticket;

class CompletDayValidator extends ConstraintValidator
{

    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param mixed $booking
     * @param Constraint $constraint
     */
    public function validate($booking, Constraint $constraint)
    {
        $ticketsSold = $this->em->getRepository(Ticket::class);
        $nbDayTickets = $ticketsSold->getNbTicketsPerDay();
        if($nbDayTickets + $booking->getNumberTicket() > Booking::MAX_TICKETS_PER_DAY)
        {
            $this->context->buildViolation("Can not reserve for this day, capacity is reached")
                ->atPath('nbTickets')
                ->addViolation();
        }

    }


}