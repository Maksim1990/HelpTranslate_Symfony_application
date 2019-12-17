<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Profile;
use AppBundle\Entity\Settings;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class RegisterController extends Controller
{
    /**
     * @Route("{_locale}/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoder $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoder $encoder)
    {
        $em=$this->getDoctrine()->getManager();
        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);


        if($form->isSubmitted() & $form->isValid()){
            // Create user
            $user->setPassword($encoder->encodePassword($user,$user->getPassword()));
            $now=new\DateTime('now');
            $user->setCreateDate($now);
            $user->setUpdatedAt($now);
            $em->persist($user);



            $em->flush();
            $userId=$user->getId();
            //Create Profile for newly registered user
            $profile = new Profile;
            $profile->setUserId($userId);
            $profile->setUpdatedAt($now);
            $profile->setCreateDate($now);

            $profile->setActive('Y');
            $em->persist($profile);
            $em->flush();

            //Create Settings for newly registered user
            $settings = new Settings;
            $settings->setUserId($userId);
            $settings->setCreatedAt($now);
            $em->persist($settings);
            $em->flush();

            $locale=$request->getLocale();
            return $this->redirectToRoute('homepage',array(
                '_locale'=>$locale
            ));
        }

        return $this->render('AppBundle:Register:register.html.twig', array(
            'form'=>$form->createView()
        ));
    }

}
