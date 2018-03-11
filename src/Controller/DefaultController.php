<?php
namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends FOSRestController
{
    /**
     * @Route("/")
     */
    public function indexAction() {
        return $this->view('ola', 200);
    }
}
