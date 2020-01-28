<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController 
{

    private $product = [];
    public function __construct()
    {
        $this->product = [
            ['name' => 'iphone X', 'slug' => 'iphone-x','description' => 'Un iphone de 2017', 'prix' => '999'],
            ['name' => 'iphone XR', 'slug' => 'iphone-xr','description' => 'Un iphone de 2018', 'prix' => '1099'],
            ['name' => 'iphone XS', 'slug' => 'iphone-xs','description' => 'Un iphone de 2018', 'prix' => '1199']
        ];
    }

    // vos routes...

    /**
    * @Route("/product/random", name="product_random")
    */

    public function random()
    {
        dump($this->product);
        $index = array_rand($this->product);
        $product = $this->product[$index];
        dump($product);

        //return new Response('<body>' .$random['name']. '</body>');
        return $this->render('product/show.html.twig', [
            'product' => $product, 
        ]);
    }

    /**
    * @Route("/product", name="product_list")
    */

    public function list()
    {
        return $this->render('product/list.html.twig', [
            'products' => $this->product,
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function create()
    {
        return $this->render('product/create.html.twig');
    }

    /**
    * @Route("/product/{slug}", name="product_show")
    */

    public function show($slug)
    {
        // le slug passé dans l'url
        dump($slug);
        // la liste des produit
        dump($this->product);

        // on va parcourire tout les produits
        foreach ($this->product as $product) {
            dump($product);
            // on va comparé le slug de chaque produit avec celui de l'url
            if ($slug === $product['slug']) {
                dump($product);
                // si un produit exxiste on retourne le template et on arrete le code
                return $this->render('product/show.html.twig', ['product' => $product]);
            }
        }

        // Apres avoir parcouru le tableau si aucun produit ne correspond on affiche une 404 
        throw $this->createNotFoundException('Le produit n\'existe pas.');
    }

}