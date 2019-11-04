<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Validator\EntryDateConstraint;
use App\Validator\FullDayConstraint;
use App\Validator\HolidayDateConstraint;
use App\Validator\CompletDayConstaint;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @FullDayConstraint()
 * @CompletDayConstaint()
 */
class Booking
{
    const WAITING_PAYMENT = 0;
    const PAYED = 1;

    const BOOKING_FULL_DAY = true;
    const BOOKING_HALF_DAY = false;
    const MAX_TICKETS_PER_DAY = 1000;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="mail",type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "le courriel '{{ value }}' n'est pas un courriel valide.",
     *  )
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @EntryDateConstraint()
     * @HolidayDateConstraint()
     * @Assert\GreaterThan("today")
     * @ORM\Column(type="date")
     *
     */
    private $entry;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $period;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $numberTicket;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="tickets",cascade={"persist"})
     */
    private $tickets;

    /**
     * @ORM\Column(type="float")
     */
    private $totalAmount;
    private $state;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->createAt=new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEntry(): ?\DateTime
    {
        return $this->entry;
    }

    public function setEntry(\DateTime $entry): self
    {
        $this->entry = $entry;

        return $this;
    }

    public function getPeriod(): ?bool
    {
        return $this->period;
    }

    public function setPeriod(bool $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getNumberTicket(): ?int
    {
        return $this->numberTicket;
    }

    public function setNumberTicket(int $numberTicket): self
    {
        $this->numberTicket = $numberTicket;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setBooking($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getBooking() === $this) {
                $ticket->setBooking(null);
            }
        }

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        if ($state !== self::WAITING_PAYMENT && $state !== self::PAYED) {
            throw new \Exception('State invalid');
        }

        $this->state = $state;

        return $this;
    }
}
