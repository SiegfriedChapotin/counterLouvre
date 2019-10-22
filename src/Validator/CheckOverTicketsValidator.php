<?php

namespace App\Validator;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckOverTicketsValidator extends ConstraintValidator
{
    private $entityManager;
    private $request;

    const TICKET_LIMIT = 1000;

    /**
     * CheckOverTicketsValidator constructor.
     * @param EntityManagerInterface $entityManager
     * @param RequestStack $request
     */
    public function __construct(EntityManagerInterface $entityManager, RequestStack $request)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        // Get current request
        $request = $this->request->getCurrentRequest();
        $currentBooking=$request->request->get('booking');

        // Get the current booking date input
        $dat = new \DateTime($currentBooking['bookingDate']);

        // Get all Booking entities by current date input
        $listBooking = $this->entityManager->getRepository(booking::class)->findBookingByDate($dat);
        $ticketsCounter = 0;

        foreach ($listBooking as $booking){

            $addCount = count($booking->getTickets());
            $ticketsCounter += $addCount;
        }

        // If entries > 1000
        if (($ticketsCounter + $value) > self::TICKET_LIMIT){
            $this->context->addViolation($constraint->message);

        }
    }


}