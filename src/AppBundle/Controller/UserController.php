<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{

    /**
     * @Route("{_locale}/profile/{id}", name="profile")
     */
    public function profileAction($id , Request $request)
    {
        $userOnline = $this->get('security.token_storage')->getToken()->getUser();
        $user=$this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $em=$this->getDoctrine()->getManager();
        $result = $em->createQueryBuilder();
        $image = $user->getImage();
//return new Response(var_dump($image[0]['imageName']));

        if(!empty($image)){
            $imageName='uploads/'.$image->getImageName();
        }else{
            $imageName='layout/profile.png';
        }

        $works=$this->getDoctrine()->getRepository('AppBundle:Todo')
            ->findBy(array('user_id'=>$id));
        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $resultWorks=$paginator->paginate(
            $works,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',10)
        );

        $teachers=$this->getDoctrine()->getRepository('AppBundle:TypeUser')
            ->findBy(array('userId'=>$id,
                'userType'=>'teacher'));

        $students=$this->getDoctrine()->getRepository('AppBundle:TypeUser')
            ->findBy(array('userId'=>$id,
                'userType'=>'student'));
        $profile=$this->getDoctrine()->getRepository('AppBundle:Profile')
            ->findOneBy(array('userId'=>$id));


        $isAlreadyVote = $this->getDoctrine()->getRepository('AppBundle:Rating')
            ->findOneBy(array( 'userProfileId'=>$id,
                'user'=>$userOnline->getId()));



        //Check possibility to vote on this page
            if($id==$userOnline->getId()){
                $alreadyVote='noVote';
            }
            elseif(!empty($isAlreadyVote)) {
                $alreadyVote = 'false';
            }else{
                $alreadyVote='true';
            }

        $myDirectory = opendir($this->get('kernel')->getRootDir() ."/../web/images/flags");
//            $myDirectory = opendir($this->get('kernel')->getRootDir() ."/../images/flags");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension=explode('.',$entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);
        $result = $em->createQueryBuilder();
        $testimonials = $result->select('t')
            ->from('AppBundle:Testimonial', 't')
            ->where('t.userProfileId= :id')
            ->setParameter('id', $user->getId())
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $result = $em->createQueryBuilder();
        $myRating = $result
            ->from('AppBundle:Rating', 'r')
            ->select('SUM(r.rating) AS rating')
            ->where('r.userProfileId= :id')
            ->setParameter('id', $user->getId())
            ->getQuery()
            ->getSingleScalarResult();
            if(empty($myRating)){
                $myRating=0;
            }


        $ratings = $this->getDoctrine()->getRepository('AppBundle:Rating')
            ->findBy(array( 'userProfileId'=>$id),
                array('createdAt' => 'DESC'));

        return $this->render('profile/index.html.twig',array(
            'user'=>$user,
            'works'=>$resultWorks,
            'teachers'=>$teachers,
            'students'=>$students,
            'profile'=>$profile,
            'alreadyVote'=>$alreadyVote,
            'arrayFlags'=>$arrayFlags,
            'testimonials'=>$testimonials->getResult(),
            'myRating'=>$myRating,
            'ratings'=>$ratings,
            'image'=>'images/'.$imageName
        ));
    }


}
