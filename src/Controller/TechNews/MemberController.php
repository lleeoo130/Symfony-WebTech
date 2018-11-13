<?php

namespace App\Controller\TechNews;


use App\Member\MemberRequest;
use App\Member\MemberRequestHandler;
use App\Member\MemberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MemberController extends Controller
{

    /**
     * Register a new Member
     * @Route   (   "/registration",
     *              name="member_registration",
     *              methods={"GET", "POST"})
     * @param Request $request
     * @param MemberRequestHandler $memberRequestHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, MemberRequestHandler $memberRequestHandler)
    {
        # Registering a new member:
        $member = new MemberRequest();

        # Creating a new form:
        $form = $this   ->createForm(MemberType::class, $member)
                        ->handleRequest($request);

        # Checking and validating the form:
        if ($form->isSubmitted() && $form->isValid())
        {
            # Registering a new Member:
            $member = $memberRequestHandler->handle($member);

            # Flash message:
            $this->addFlash('notice', 'Congrats, you are now registered!');

            # Redirecting:
            $this->redirectToRoute('security_login');
        }

        # Displaying the form:
        return $this->render('member/registration.html.twig', [
                    'form'  => $form->createView()
        ]);
    }
}