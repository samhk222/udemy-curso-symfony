<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\MicroPostRepository;

/**
 * @Route("/micro-post");
 */
class MicroPostController extends AbstractController
{

    private $microPostRepository;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __contruct(MicroPostRepository $microPostRepository){
      $this->microPostRepository = $microPostRepository;
      $this->twig = $twig;

      dump($twig);
    }
    /**
     * @Route("/", name="micro_post_index")
     */
    public function index(\Twig_Environment $twig){
        
        return $this->render('micro-post/index.html.twig',[
            'posts' => []
        ]);
    }

}