<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\MicroPostRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\MicroPost;
use App\Form\MicroPostType;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @Route("/micro-post");
 */
class MicroPostController extends AbstractController
{

    private $microPostRepository;
    private $twig;
    private $formFactory;
    private $entityManager;
    private $flashbag;

    public function __construct(
        MicroPostRepository $microPostRepository, 
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashbag
    ){
      $this->microPostRepository = $microPostRepository;
      $this->entityManager = $entityManager;
      $this->flashbag = $flashbag;

    }
    /**
     * @Route("/", name="micro_post_index")
     */
    public function index(){
        
        return $this->render('micro-post/index.html.twig',[
            //'posts' => $this->microPostRepository->findAll()
            'posts' => $this->microPostRepository->findBy([],[
                'time'=>'DESC'
            ])
        ]);
    }

    /**
     * @Route("/add", name="micro_post_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager, RouterInterface $router){
        
        $micropost = new MicroPost();
        $micropost->setTime(new \DateTime());

        // $form = $formFactory->create(MicroPostType::class, $micropost);


        /**
         * 
         * 
         * Pode ser dessa forma para criar o formulário
         * 
            $form = $this->createFormBuilder($micropost)
            ->add('text', TextareaType::class, ['label'=>false])
            ->add('save', SubmitType::class, ['label' => 'Criar Post'])
            ->getForm();
         */

        /**
         * 
         * Ou pode ser dessa forma para criar o formulário, criando 1 classe de helper
         * 
         */
        $form = $this->createForm(MicroPostType::class, $micropost);

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

    /**
     * @Route("/delete/{id}", name="micro_post_delete")
     */
    public function delete($id, MicroPost $micropost){

        /**
         * Dessa forma funciona também, retirando o Micropost dos parâmetros
        $micropost = $this->getDoctrine()->getRepository(MicroPost::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove( $micropost );
        $entityManager->flush();

        return $this->redirectToRoute('micro_post_index') ;
        */

        $this->entityManager->remove($micropost);
        //$this->entityManager->flush();

        //$this->flashBag->add('notice', 'Registro Excluído');

        return $this->redirectToRoute('micro_post_index') ;



    }

    /**
     * @Route("/{id}", name="micro_post_blog")
     */
    public function post($id){
       

        //dump( $env = $this->getParameter('kernel.environment') );

        $post = $this->microPostRepository->find($id);


        return $this->render('micro-post/post.html.twig',[
            'post' => $post
        ]);
    }



    /**
     * @Route("/edit/{id}", name="micro_post_edit")
     */
    public function edit($id, EntityManagerInterface $entityManager, Request $request, RouterInterface $router){
       
        $micropost = $this->microPostRepository->find($id);
        dump($micropost);
        dump($id);

        $form = $this->createForm(MicroPostType::class, $micropost);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // Quando estamos salvando não precisa do persist
            // $entityManager->persist($micropost);
            $entityManager->flush();
            return new RedirectResponse( $router->generate('micro_post_index') );
            
        }

        return $this->render('micro-post/add.html.twig',[
            'posts' => $this->microPostRepository->findAll(),
            'form' => $form->createView()
        ]);

    }


}