<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Settings;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{


    /**
     * @Route("{_locale}/change_sidebar_color_ajax" , name="change_sidebar_color_ajax")
     */
    public function ajaxSidebarColorAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $sidebar_color=$request->request->get('sidebar_color');
        $settings = $this->getDoctrine()->getRepository('AppBundle:Settings')->findOneBy(array('userId'=>$user->getId()));

        $now=new\DateTime('now');


        $settings->setSidebarColor($sidebar_color);
        $settings->setUserId($user->getId());
        $settings->setCreatedAt($now);

            $em=$this->getDoctrine()->getManager();
            $em->persist($settings);
            $em->flush();
        $session = $this->get('session');
        $session->set('sidebar_color',$sidebar_color);
        $arrData = ['output' => "Success"];
        return new JsonResponse($arrData);
    }


    /**
     * @Route("{_locale}/change_background_color_ajax" , name="change_background_color_ajax")
     */
    public function ajaxBackgroundColorAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $background_color=$request->request->get('background_color');
        $settings = $this->getDoctrine()->getRepository('AppBundle:Settings')->findOneBy(array('userId'=>$user->getId()));

        $now=new\DateTime('now');


        $settings->setBackgroundColor($background_color);
        $settings->setUserId($user->getId());
        $settings->setCreatedAt($now);

        $em=$this->getDoctrine()->getManager();
        $em->persist($settings);
        $em->flush();
        $session = $this->get('session');
        $session->set('background_color',$background_color);
        $arrData = ['output' => "Success"];
        return new JsonResponse($arrData);
    }


    /**
     * @Route("{_locale}/change_header_color_ajax" , name="change_header_color_ajax")
     */
    public function ajaxHeaderColorAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $header_color=$request->request->get('header_color');
        $settings = $this->getDoctrine()->getRepository('AppBundle:Settings')->findOneBy(array('userId'=>$user->getId()));

        $now=new\DateTime('now');


        $settings->setHeaderColor($header_color);
        $settings->setUserId($user->getId());
        $settings->setCreatedAt($now);

        $em=$this->getDoctrine()->getManager();
        $em->persist($settings);
        $em->flush();
        $session = $this->get('session');
        $session->set('header_color',$header_color);
        $arrData = ['output' => "Success"];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("{_locale}/change_footer_color_ajax" , name="change_footer_color_ajax")
     */
    public function ajaxFooterColorAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $footer_color=$request->request->get('footer_color');
        $settings = $this->getDoctrine()->getRepository('AppBundle:Settings')->findOneBy(array('userId'=>$user->getId()));

        $now=new\DateTime('now');


        $settings->setFooterColor($footer_color);
        $settings->setUserId($user->getId());
        $settings->setCreatedAt($now);

        $em=$this->getDoctrine()->getManager();
        $em->persist($settings);
        $em->flush();
        $session = $this->get('session');
        $session->set('footer_color',$footer_color);
        $arrData = ['output' => "Success"];
        return new JsonResponse($arrData);
    }


    /**
     * @Route("{_locale}/show_email_ajax" , name="show_email_ajax")
     */
    public function ajaxShowEmailAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $show_email=$request->request->get('strStatus');
        $settings = $this->getDoctrine()->getRepository('AppBundle:Settings')->findOneBy(array('userId'=>$user->getId()));

        $now=new\DateTime('now');


        $settings->setShowEmail($show_email);
        $settings->setUserId($user->getId());
        $settings->setCreatedAt($now);

        $em=$this->getDoctrine()->getManager();
        $em->persist($settings);
        $em->flush();
        $session = $this->get('session');
        $session->set('show_email',$show_email);
        $arrData = ['output' => $show_email];
        return new JsonResponse($arrData);
    }


}
