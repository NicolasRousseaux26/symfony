<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{   
    /**
     * @Route("/hello", name="hello")
     */
 /*   public function hello()
    {
        $name = 'Nicolas';

        return $this->render('welcome/hello.html.twig', [
            'name' => $name,
        ]);
    }
*/
    /**
     * Si on se rend sur /hello/*
     *
     * @Route("/hello/{name}", name="hello_show", requirements={"name"="[a-z]{3,10}"})
     */
 /*   public function show($name = 'nicolas')
    {
        // La variable $slug contiendra la valeur dynamique de l'URL
        // Par exemple, sur /hello/symfony alors $slug = 'symfony'
        // ...
        

        return $this->render('welcome/hello.html.twig', [
            'name' => ucfirst($name),
        ]);
    }
  */
      /**
     * @Route(
     *    "/hello/{name}",
     *    name="hello",
     *    requirements={"name"="[a-z]{3,8}"}
     * )
     *
     * Mon commentaire.
     */
    public function hello($name = 'Matthieu')
    {
        // $name = 'Matthieu';

        dump($name);

        return $this->render('welcome/hello.html.twig', [
            'name' => ucfirst($name),
        ]);
    }
}