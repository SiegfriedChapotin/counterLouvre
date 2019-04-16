<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $entry;

    /**
     * @ORM\Column(type="boolean")
     */
    private $period;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberTicket;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="tickets", orphanRemoval=true)
     */
    private $tickets;

    /**
     * @ORM\Column(type="float")
     */
    private $totalAmount;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
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
}
