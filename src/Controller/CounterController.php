<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Form\BookingType;
use App\Form\TicketsType;
use App\Manager\TicketManager;
use App\Services\PriceCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CounterController extends AbstractController
{

    /**
     * @var TicketManager
     */
    private $ticketManager;

    public function __construct(TicketManager $ticketManager)
    {
        $this->ticketManager = $ticketManager;
    }

    /**
     * @Route("/", name="booking")
     */
    public function bookingAction(Request $request, EntityManagerInterface $em)
    {
        $booking = $request->getSession()->get('booking', new Booking());
        $bookingForm = $this->createForm(BookingType::class, $booking);
        $bookingForm->handleRequest($request);

        if ($bookingForm->isSubmitted() && $bookingForm->isValid()) {
            $request->getSession()->set('booking', $booking);

            return $this->redirectToRoute('booking_tickets', ['booking' => $booking->getId()]);
        }

        return $this->render('counter/booking.html.twig', [
            'bookingForm' => $bookingForm->createView()
        ]);
    }

    /**
     * @Route("/tickets", name="booking_tickets")
     */
    public function bookingTicketsAction( Request $request, PriceCalculator $priceCalculator)
    {
        $booking = $request->getSession()->get('booking');

        if (!$booking){
            return $this->redirectToRoute('booking');
        }

        $nbTicket = $booking->getNumberTicket();

        for ($i = $booking->getTickets()->count(); $i < $nbTicket; $i++) {
            $booking->addTicket(new Ticket());
            $priceCalculator->computePrice($$booking);
        }

        for ($i = $nbTicket; $i < $booking->getTickets()->count(); $i++) {
            $booking->removeTicket($booking->getTickets()->last());
        }

        $ticketsForm = $this->createForm(TicketsType::class, $booking);
        $ticketsForm->handleRequest($request);

        if ($ticketsForm->isSubmitted() && $ticketsForm->isValid()) {

            return $this->redirectToRoute('indent_order', ['booking' => $booking->getId()]);
        }

        return $this->render('counter/booking_tickets.html.twig', [
            'ticketsForm' => $ticketsForm->createView(),
            'reservation'=>$booking

        ]);
    }

    /**
     * @Route("/order", name="indent_order")
     */
    public function indentAction(Request $request )
    {
        $booking = $request->getSession()->get('booking');


        return $this->render('counter/order.html.twig', [

            'commande'=>$booking
        ]);
    }
}
