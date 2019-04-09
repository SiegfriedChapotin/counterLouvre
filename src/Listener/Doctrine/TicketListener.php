<?php


namespace App\Listener\Doctrine;


use App\Entity\Ticket;
use App\Manager\TicketManager;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TicketListener
{
    /**
     * @var TicketManager
     */
    private $ticketManager;

    public function __construct(TicketManager $ticketManager)
    {
        $this->ticketManager = $ticketManager;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Ticket) {
            return;
        }

        $this->ticketManager->updateTicketPrice($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Ticket) {
            return;
        }

        $this->ticketManager->updateTicketPrice($entity);

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }
}