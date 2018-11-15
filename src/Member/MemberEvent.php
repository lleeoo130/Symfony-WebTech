<?php

namespace App\Member;

use App\Entity\Member;
use Symfony\Component\EventDispatcher\Event;



class MemberEvent extends Event
{

    private $member;

    /**
     * MemberEvent constructor.
     * @param $member
     */
    public function __construct($member)
    {
        $this->member = $member;
    }

    public function getMember(): Member
    {
        return $this->member;
    }


}