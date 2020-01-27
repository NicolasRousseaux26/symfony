<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function hello()
    {
        $name = 'Nicolas';

        return $this->render('welcome/hello.html.twig', [
            'name' => $name,
        ]);
    }
}