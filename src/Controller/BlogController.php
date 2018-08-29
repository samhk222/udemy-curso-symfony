<?php
/**
 * Created by PhpStorm.
 * User: samhk222
 * Date: 28/08/18
 * Time: 16:31
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/blog");
 */
class BlogController extends AbstractController
{
    public function __construct(SessionInterface $session, RouterInterface $router)
    {
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @Route("/", name="blog_index")
     */
    public function index(){
        return $this->render('blog/index.html.twig',[
            'posts' => $this->session->get('posts')
        ]);
    }

    /**
     * @Route("/serverInfo", name="blog_info")
     */
    public function serverInfo(){
        return $this->render('blog/serverInfo.html.twig',[]);
    }

    public function getGlobals(){
        /**
         * Está dentro do services.yaml
        */
        return [
            'locale' => $this->locale
        ];
    }

    /**
     * @Route("/add", name="blog_add")
     */
    public function add(){
        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            'title' => "qualquer título " .rand(1,100),
            'text' => 'some random text nr ' .rand(1,1000),
            'date' => new \DateTime()
        ];
        $this->session->set('posts', $posts);
        return new RedirectResponse( $this->router->generate("blog_index") );


    }

    /**
     * @Route("/show/{id}", name="blog_show")
     */
    public function show($id){
        $posts = $this->session->get('posts');

        if (!$posts || !isset($posts[$id]) ){
            throw new NotFoundHttpException('Post Not found');
        }

        return $this->render('blog/post.html.twig',[
            'id' => $id,
            'post' => $posts[$id]

        ]);
    }

}