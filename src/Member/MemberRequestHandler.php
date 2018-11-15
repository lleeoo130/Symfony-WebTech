<?php

namespace App\Member;


use App\Entity\Member;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MemberRequestHandler
{
    private $manager, $memberFactory, $dispatcher;

    public function __construct( ObjectManager $manager,
                                 MemberFactory $memberFactory,
                                 EventDispatcherInterface $dispatcher )
    {
        $this->manager          = $manager;
        $this->memberFactory    = $memberFactory;
        $this->dispatcher       = $dispatcher;
    }

    public function handle(MemberRequest $request): ?Member
    {
        # Creating a Member Object:
        $member = $this->memberFactory->createFromMemberRequest($request);

        # Saving in DB:
        $this->manager->persist($member);
        $this->manager->flush();

        # Dispatching the event:
        $this->dispatcher->dispatch(MemberEvents::MEMBER_CREATED, new MemberEvent($member));

        # Returning the new member
        return $member;
    }
}