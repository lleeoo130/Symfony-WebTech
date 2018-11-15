<?php

namespace App\Member\EventListener;


use App\Entity\Member;
use App\Entity\Newsletter;
use App\Member\MemberEvent;
use App\Member\MemberEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class MemberSubscriber implements EventSubscriberInterface
{
    private $em;

    /**
     * MemberSubscriber constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN   => 'updateDateLastConnection',
            MemberEvents::MEMBER_CREATED        => 'onMemberCreated'
        ];
    }


    public function onMemberCreated(MemberEvent $event)
    {
        $newsletter = new Newsletter();
        $newsletter->setEmail($event->getMember()->getEmail());

        $this->em->persist($newsletter);
        $this->em->flush();
    }


    public function updateDateLastConnection(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof Member){

            $user->setDateLastConnection();


                $this->em->flush();

        }
    }
}