<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\MicroPostRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\MicroPost;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @Route("/micro-post");
 */
class MicroPostController extends AbstractController
{

    private $microPostRepository;
    private $twig;
    private $formFactory;
    private $request;

    public function __construct(MicroPostRepository $microPostRepository){
      $this->microPostRepository = $microPostRepository;
    //   $this->formFactory = $formFactory;
    //   $this->request = $request;
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

    /**
     * @Route("/add", name="micro_post_add")
     */
    public function add(FormFactoryInterface $formFactory, Request $request, EntityManagerInterface $entityManager, RouterInterface $router){
        
        $micropost = new MicroPost();
        $micropost->setTime(new \DateTime());

        // $form = $formFactory->create(MicroPostType::class, $micropost);

        $form = $this->createFormBuilder($micropost)
            ->add('text', TextareaType::class, ['label'=>false])
            ->add('save', SubmitType::class, ['label' => 'Criar Post'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($micropost);
            $entityManager->flush();
            return new RedirectResponse( $router->generate('micro_post_index') );
            
        }

        return $this->render('micro-post/add.html.twig',[
            'posts' => $this->microPostRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

}