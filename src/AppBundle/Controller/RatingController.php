<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class RatingController extends Controller
{

    /**
     * @Route("{_locale}/rating/ajax" , name="rating_ajax")
     */
    public function ajaxAction(Request $request) {
        if($ratingNumber=$request->request->get('rating')){
            $rating = new Rating;
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $now=new\DateTime('now');

            $rating->setRating($ratingNumber);
            $rating->setUser($user);
            $rating->setUserProfileId($request->request->get('user_profile_id'));
            $rating->setCreatedAt($now);
            $rating->setUpdatedAt($now);

            $em=$this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();

            $arrData = ['output' => $ratingNumber];
            return new JsonResponse($arrData);
        }
    }


}
