<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Ticket;
use App\Form\BookingType;
use App\Form\TicketsType;
use App\Manager\TicketManager;
use App\Services\CodeNumberGenerator;
use App\Services\PriceCalculator;
use App\Services\StripeHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response ;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CounterController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Request
     */
    private $request;

    /**
     * @var TicketManager
     */
    private $ticketManager;

    public function __construct(TicketManager $ticketManager,RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->ticketManager = $ticketManager;
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
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
    public function bookingTicketsAction(Request $request, PriceCalculator $priceCalculator)
    {
        $booking = $request->getSession()->get('booking');


        if (!$booking) {
            return $this->redirectToRoute('booking');
        }

        $nbTicket = $booking->getNumberTicket();

        for ($i = $booking->getTickets()->count(); $i < $nbTicket; $i++) {
            $booking->addTicket(new Ticket());

        }

        $initNbTicket = $booking->getTickets()->count();

        for ($i = $nbTicket; $i < $initNbTicket; $i++) {
            $booking->removeTicket($booking->getTickets()->last());
        }

        $ticketsForm = $this->createForm(TicketsType::class, $booking);
        $ticketsForm->handleRequest($request);

        if ($ticketsForm->isSubmitted() && $ticketsForm->isValid()) {

            $priceCalculator->computePrice($booking);
            return $this->redirectToRoute('indent_order', ['booking' => $booking->getId()]);
        }


        return $this->render('counter/booking_tickets.html.twig', [
            'ticketsForm' => $ticketsForm->createView(),
            'reservation' => $booking

        ]);
    }

    /**
     * @Route("/order", name="indent_order")
     */
    public function indentAction(Request $request)
    {
        $booking = $request->getSession()->get('booking');

        return $this->render('counter/order.html.twig', [
            'reservation' => $booking

        ]);
    }

    /**
     * @Route("/payment", name="payment_order")
     */
    public function paymenttAction(Request $request, StripeHandler $stripeHandler, \Swift_Mailer $mailer): Response
    {
        /** @var Booking $booking */
        $booking = $request->getSession()->get('booking');

        $form = $this->createFormBuilder()
            ->add('stripeToken', HiddenType::class)
            ->getForm();
        $form->handleRequest($this->request);



        if ($form->isSubmitted() && $form->isValid()) {

            $code=rand(1000,100000);
            $booking->setCodeBooking($code);
            $email = $booking->getEmail();

            $message = (new \Swift_Message('Vos entrées pour le Musée du Louvre'))
                ->setFrom($email)
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'counter/Emails/mailer.html.twig',
                        ['book'=>$booking]),
                         'text/html'
                         );
            $mailer->send($message);

 			$stripeHandler->charge($booking->getTotalAmount()*100, $form->getData()['stripeToken']);
            $this->em->persist($booking);
            $this->em->flush();
            return $this->redirectToRoute('order_done', ['id' => $booking->getId()]);
        }


        return $this->render('counter/payment.html.twig', [
            'payment' => $booking,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/done", name="order_done")
     */
    public function doneAction(Request $request)
    {
        $booking = $request->getSession()->get('booking');

        return $this->render('counter/order_done.html.twig',['payment' => $booking,]);
    }
}
