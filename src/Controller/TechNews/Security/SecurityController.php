<?php

namespace App\Controller\TechNews\Security;



use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    /**
     * @Route({"en":"/{_locale}/login",
     *        "fr": "/{_locale}/connexion"},
     *          name="security_login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils )
    {
        if ($this->getUser())
        {
            return $this->redirectToRoute('index');
        }

        # Getting the connexion form:
        $form = $this->createForm(LoginType::class, [
                                                    'email' => $authenticationUtils->getLastUsername()
        ]);

        # Getting error messages:
        $error = $authenticationUtils->getLastAuthenticationError();

        # To the view:
        return $this->render('security/connexion.html.twig', [
                        'form'  => $form->createView(),
                        'error' => $error
        ]);
    }

    /**
     * @Route({"en":"/{_locale}/logout",
     *         "fr":"/{_locale}/deconnexion"},
     *     name="security_logout")
     */
    public function logout()
    {
        $this->redirectToRoute('index');
    }

    /*
     * We could define here some more logical code,
     * forgotten password, reinitialisation, verification email
     */

}