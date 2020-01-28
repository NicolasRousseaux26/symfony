<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    /**
     * @Route("/demo", name="demo")
     */
    public function index(Request $request)
    {
        // Récupérer $_GET['A']
        dump($request->query->get('A'));
        // $request->get('A'); $_GET['A'] ou $_POST['A']

        // Récupèrer IP utilisateur
        dump($request->server->get('REMOTE_ADDR'));

        // Renvoie un objet Request
        dump($request);

        return $this->render('demo/index.html.twig', [
            'controller_name' => 'DemoController',
        ]);
    }

    /**
     * @Route("/toto", name="toto")
     * 
     * Redirige vers /demo
     */
    public function toto()
    {
        dump('REQUETE SQL');
        dump('ENVOI UN EMAIL');

        return $this->redirectToRoute('demo');
    }

    /**
     * @Route("/event/{slug}")
     */
    public function showEvent(Request $request, $slug, LoggerInterface $logger)
    {
        // Mes événements
        $events = ['a', 'b', 'c'];

        if (!in_array($slug, $events)) {
            // Si le slug n'est pas dans le tableau
            throw $this->createNotFoundException('Cet événement n\'existe pas.');
        }

        // On peut logguer des "trucs" dans Symfony
        $ip = $request->server->get('REMOTE_ADDR');
        dump(get_class($logger));
        $logger->info($ip.' a vu l\'événement '.$slug);

        return new Response('<body>'.$slug.'</body>');
    }

    /**
     * On va créer deux nouvelles routes :
     * /voir-session : Afficher le contenu de la clé 'name' dans la session
     *                 N'affiche rien lors de la première visite sur le site
     * /mettre-en-session/{name} : Mettre en session la valeur passée dans l'URL
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
        // Je mets $name en session
        $session->set('name', $name); // Equivaut à $_SESSION['name'] = $name;

        // on peut crée un message flash
        $this->addFlash('success', 'Message de succès');

        return $this->redirectToRoute('show_session');
    }

    /**
     * @Route("protected.pdf", name="cv")
     */
    public function downloadCV()
    {
        $authorized = (bool) rand(0, 1); // hi hi hi seci et aleatoire ! 
        if ($authorized){
            throw $this->createNotFoundException('Vous ne pouvez pas récuperez ce CV.');
        }
        return $this->file('../cv.pdf', 'new_file.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }   // lien: http://localhost:8000/protected.pdf
}