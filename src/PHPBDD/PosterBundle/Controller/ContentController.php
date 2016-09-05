<?php

namespace PHPBDD\PosterBundle\Controller;

use PHPBDD\PosterBundle\Entity\Posts;
use PHPBDD\PosterBundle\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContentController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->createQueryBuilder()
            ->select('b')
            ->from('PHPBDDPosterBundle:Posts', 'b')
            ->addOrderBy('b.created', 'DESC')
            ->getQuery()
            ->getResult();
        $image_dir = __DIR__.'/../../../../web/images';
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        if ($request->isMethod($request::METHOD_POST))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $image = $form['image']->getData();
                $image->move($image_dir , $image->getClientOriginalName());
                $post->setImage($image->getClientOriginalName());
                $em->persist($post);
                $em->flush();
                return $this->redirect($this->generateUrl('phpbdd_poster_homepage'));
            }
        }
        return $this->render('PHPBDDPosterBundle:Content:index.html.twig', array(
            'blogs' => $blogs,
            'form' => $form->createView()
        ));
    }
}