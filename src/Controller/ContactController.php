<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\{Route};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Model\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($contact);
            $this->addFlash('success', 'Votre message a bien été envoyé.');

            $email = (new Email())
                ->from('contact@monsit.com')
                ->to('admin@monsit.com')        //a activer dens le fichier .env a la fin
                ->subject($contact->getName().' a fait une demende')
                ->html('<h1>Email: '.$contact->getEmail().'</h1>');

            $mailer->send($email);
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}