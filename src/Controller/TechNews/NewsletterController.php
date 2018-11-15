<?php

namespace App\Controller\TechNews;

use App\Newsletter\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsletterController extends Controller
{

    /**
     * Displays Newsletter Modal
     *
     */
    public function newsletter()
    {
        # Getting the form:
        $form = $this->createForm(NewsletterType::class);

        # Creating the view:
        return $this->render('newsletter/_modal.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}