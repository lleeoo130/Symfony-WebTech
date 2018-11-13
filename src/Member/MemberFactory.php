<?php

namespace App\Member;


use App\Entity\Member;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MemberFactory
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function createFromMemberRequest(MemberRequest $request): Member
    {
        $member = new Member();
        $member->setFirstName($request->getFirstName());
        $member->setLastName($request->getLastName());
        $member->setEmail($request->getEmail());
        $member->setRole($request->getRoles());
        $member->setPassword($this->encoder->encodePassword(
                                                            $member,
                                                            $request->getPassword()));

        return $member;
    }
}