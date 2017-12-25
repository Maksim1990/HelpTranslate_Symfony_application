<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Testimonial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TestimonialController extends Controller
{

    /**
     * @Route("{_locale}/testimonial_ajax" , name="testimonial_ajax")
     */
    public function ajaxAction(Request $request) {
        if($description=$request->request->get('description')){
            $testimonial = new Testimonial;
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $now=new\DateTime('now');
            $language_type=$request->request->get('language_type');
            $user_profile_type=$request->request->get('user_profile_type');
            $user_type=$request->request->get('user_type');

            $testimonial->setDescription($description);
            $testimonial->setUserProfileType($user_profile_type);
            $testimonial->setUserType($user_type);
            $testimonial->setLanguageType($language_type);
            $testimonial->setUserProfileId($request->request->get('user_profile_id'));
            $testimonial->setCreatedAt($now);
            $testimonial->setUser($user);

            $em=$this->getDoctrine()->getManager();
            $em->persist($testimonial);
            $em->flush();

            $arrData = ['output' => $description];
            return new JsonResponse($arrData);
        }
    }

}
