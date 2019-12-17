<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{

    /**
 * @Route("{_locale}/update_image/", name="update")
 */
    public function updateImageAction(Request $request)
    {

        //RedisLab block
        $redis_cluster = $this->container->get('snc_redis.default');
        $val = $redis_cluster->get('profile_image_path')?$redis_cluster->get('profile_image_path'):'false';

        $redis_cluster->set('test33','Test VARIABLE');
        $test=$redis_cluster->get('test33');
        //$redis_cluster->set('test_2','Test 222');
        $test2=$redis_cluster->get('test_2');
        //$redis_cluster->del("mycounter");
        $keys = $redis_cluster->keys("*");
        $check=($redis_cluster->exists("profile_image_path")) ? "true" : "false";




        $user = $this->get('security.token_storage')->getToken()->getUser();
        $image = new Image;
        $form=$this->createFormBuilder( $image)
            ->add('imageFile',FileType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('submit',SubmitType::class,array('label'=>'Register','attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px;')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $imageFile=$form['imageFile']->getData();
            $dir='images/uploads';
            $imageFile->move($dir, $imageFile->getClientOriginalName());


           // $redis_cluster->set('profile_image_path', $dir.'/'. $imageFile->getClientOriginalName());
            $session = $this->get('session');
            $session->set('user', array(
                'profile_image_path' => $dir.'/'. $imageFile->getClientOriginalName(),
            ));


            $image->setImageName($imageFile->getClientOriginalName());
            $image->setImageSize($imageFile->getClientSize());
            $image->setUser($user);
            $now=new\DateTime('now');
            $image->setCreatedAt($now);
            $image->setUpdatedAt($now);
            $em=$this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            $this->addFlash('notice','Image successfully updated');
            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }
        return $this->render('profile/edit.html.twig',array(
            'form'=>$form->createView(),
           'val'=>$val,
           'test'=>$test,
           'test2'=>$test2,
           'keys'=>$keys,
           'check'=>$check
        ));

    }

    /**
     * @Route("{_locale}/delete_profile_image/{id}", name="delete_profile_image")
     */
    public function deleteProfileImageAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();
        $image = $user->getImage();

        unlink('images/uploads/'.$image->getImageName());
        $query = $em->createQuery('DELETE AppBundle:Image c WHERE c.id ='.$image->getId());
        $query->execute();

        $session = $this->get('session');
        $session->set('user', array(
            'profile_image_path' => '/images/layout/profile.png',
        ));

        return $this->redirectToRoute('profile', ['id' => $id]);

    }

}
