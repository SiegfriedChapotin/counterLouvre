<?php


namespace App\Services;

use App\Entity\Booking;


class PriceCalculator
{
    // age range in years
    const BABY_AGE = 4;
    const CHILD_AGE = 12;
    const SENIOR_AGE = 60;

    // prices in €
    const BABY_PRICE = 0;
    const CHILD_PRICE = 8;
    const SENIOR_PRICE = 12;
    const NORMAL_PRICE = 16;
    const REDUCED_PRICE = 10;

    // duration of visit
    const FULL_DAY = 1;
    const HALF_DAY = 0.5;

    private $visitDuration;

    public function computePrice(Booking $order) {

        if ($order->getPeriod()) {
            $this->visitDuration = self::FULL_DAY;
        } else {
            $this->visitDuration = self::HALF_DAY;
        }

        $tickets = $order->getTickets();
        $dateOfVisit = $order->getEntry();
        $totalPrice = 0;

        foreach ($tickets as $ticket) {
            $price = 0;
            $age = $ticket->getBirthday()->diff($dateOfVisit)->format('%y');



            if ($age < self::BABY_AGE) {
                $price = self::BABY_PRICE;
            } elseif ($age < self::CHILD_AGE) {
                $price = self::CHILD_PRICE;
            } elseif ($age < self::SENIOR_AGE) {
                $price = self::NORMAL_PRICE;
            } else {
                $price = self::SENIOR_PRICE;
            }

            if ($ticket->getReduced() && $price > self::REDUCED_PRICE) {
                $price = self::REDUCED_PRICE;
            }

            $price = $price * $this->visitDuration;

            $ticket->setPrice($price);

            $totalPrice += $price;
        }

        $order->setTotalAmount($totalPrice);

        return $order;

    }

}