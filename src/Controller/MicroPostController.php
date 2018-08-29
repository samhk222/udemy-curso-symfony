<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\MicroPostRepository;

/**
 * @Route("/micro-post");
 */
class MicroPostController extends AbstractController
{

    private $microPostRepository;
    private $twig;

    public function __construct(MicroPostRepository $microPostRepository){
      $this->microPostRepository = $microPostRepository;
      //dump($microPostRepository);
    }
    /**
     * @Route("/", name="micro_post_index")
     */
    public function index(){
        
        return $this->render('micro-post/index.html.twig',[
            'posts' => $this->microPostRepository->findAll()
        ]);
    }

}