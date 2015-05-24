<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/set-locale/{locale}", name="set_locale")
     */
    public function setLocaleAction($locale, Request $request)
    {
        $request->getSession()->set('_locale', $locale);

        //return $this->redirect($request->headers->get('referer'));
        return $this->redirectToRoute('homepage', [
            '_locale' => $locale,
        ]);
    }
}
