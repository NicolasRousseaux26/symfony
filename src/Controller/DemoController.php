<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    /**
     * @Route("/demo", name="demo")
     */
    public function index(Request $request)
    {

        //recupére $_get['a']
        dump($request->query->get('a'));
        // possible aussi comme seci: dump($request->get('a'));

        // recupére l'ip utilisateur
        dump($request->server->get('REMOTE_ADDR'));

        //renvoie un objet request
        dump($request);

        return $this->render('demo/index.html.twig', [
            'controller_name' => 'DemoController',
        ]);
    }

    /**
     * @Route("toto", name="toto")
     * 
     * Redirige vers /demo
     */
    public function toto() 
    {
        dump('REQUETE SQL');
        dump('ENVOIE UN EMAIL');


        return $this->redirectToRoute('demo');
    }
    /**
     *  @Route("/event/{slug}")
     */
    public function showEvent(Request $request, $slug, LoggerInterface $logger)
    {
        //mes evenements
        $events = ['a', 'b', 'c'];

        if (in_array($slug, $events)) {
            //si le slug nest pas dans le tableau
            throw $this->createNotFoundException('cet événement n\'existe pas.');
        }

        $ip = $request->server->get('REMOTE_ADDR');
        $logger->info($ip. 'a vue l\'evenement '.$slug); 

        return new Response('<body>'.$slug.'</body>');
    }
}
