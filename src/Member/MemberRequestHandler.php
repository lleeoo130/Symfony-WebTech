<?php

namespace App\Member;


use App\Entity\Member;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class MemberRequestHandler
{
    private $manager, $memberFactory;

    public function __construct(ObjectManager $manager, MemberFactory $memberFactory)
    {
        $this->manager = $manager;
        $this->memberFactory = $memberFactory;
    }

    public function handle(MemberRequest $request): ?Member
    {
        # Creating a Member Object:
        $member = $this->memberFactory->createFromMemberRequest($request);

        # Saving in DB:
        $this->manager->persist($member);
        $this->manager->flush();

        # Returning the new member
        return $member;
    }
}