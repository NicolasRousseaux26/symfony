<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    /**
     * on va crée deux nouvelle route 
     * /voir session : affiche le contenue de la cle 'name' dans la session 
     *                  n'affiche rien lors de la premiére visite sur le sit 
     * /mettre en session/name : mettre en session la valeur passer dans l'url 
     */

    /**
    * @Route("/voir-session", name="show_session")
    */

    public function showSession(SessionInterface $session) 
    {
        dump($session->get('name'));

        return $this->render('demo/show_session.html.twig');
    }

    /**
    * @Route("/mettre-en-session/{name}", name="put_session")
    */
    public function putSession($name, SessionInterface $session) 
    {
        // je met $name en session 
        $session->set('name', $name); // equivaut a $_session['name'] = $name;

        return $this->redirectToRoute('show_session');
    }
}
