<?php

namespace AppBundle\Controller;

use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Eko\GoogleTranslateBundle\Translate\Method\Languages;

class LoginController extends Controller
{


    /**
     * @Route("{_locale}/welcome",name="welcome")
     */
    public function welcomeAction()
    {
        return $this->render('homepage.html.twig');
    }


    /**
     * @Route("{_locale}/login",name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $errors=$authenticationUtils->getLastAuthenticationError();

        $lastUserName= $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Login:login.html.twig', array(
            'errors'=>$errors,
            'username'=>$lastUserName
        ));
    }


    /**
     * @Route("/", name="homepage_login")
     */
    public function homepageAction(Request $request)
    {
        $locale = $request->getLocale();
        $session = $this->get('session');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $image2=$user->getImage();
        $user_settings=$this->getDoctrine()->getRepository('AppBundle:Settings')->findOneBy(array('userId'=>$user->getId()));
        $imagePath=$image2?'uploads/'.$image2->getImageName():'layout/profile.png';
        $imageName2='images/'.$imagePath;
        $background_color=$user_settings->getBackgroundColor();
        $sidebar_color=$user_settings->getSidebarColor();
        $header_color=$user_settings->getHeaderColor();
        $footer_color=$user_settings->getFooterColor();
        $show_email=$user_settings->getShowEmail();
        $session->set('user', array(
            'profile_image_path' => $imageName2,
        ));
        $session->set('background_color', $background_color);
        $session->set('sidebar_color', $sidebar_color);
        $session->set('header_color', $header_color);
        $session->set('footer_color', $footer_color);
        $session->set('show_email', $show_email);


        $redis_cluster = $this->container->get('snc_redis.default');

        if($redis_cluster->exists("count_works")){
            $todosCount = $redis_cluster->get("count_works");
        }else {
            $todos = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();
            $todosCount = count($todos);
        }

        //-- Check if count_teachers Redis variable is exist
        if($redis_cluster->exists("count_teachers")){
            $teachersCount=$redis_cluster->get("count_teachers");
        }else {
            $teachers = $this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType' => 'teacher'));
            $teachersCount = count($teachers);
        }

        //-- Check if count_students Redis variable is exist
        if($redis_cluster->exists("count_students")){
            $studentsCount =$redis_cluster->get("count_students");
        }else {
            $students = $this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBY(array('userType' => 'student'));
            $studentsCount = count($students);
        }



        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        //-- Check if count_language Redis variable is exist
        if($redis_cluster->exists("count_languages")){
            $languagesList=$redis_cluster->get("count_languages");
        }else{
            //-- Block og getting unique languages array
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();

            $q = $qb->select(array('p.languageType'))
                ->from('AppBundle:Todo', 'p')
                ->where(
                    $qb->expr()->gte('p.id', '1')
                )
                ->orderBy('p.createDate', 'DESC')
                ->getQuery();

            $todo = $q->getResult(Query::HYDRATE_ARRAY);
            foreach ($todo as $lang) {
                $languagesList[] = $lang['languageType'];
            }


            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();

            $q = $qb->select(array('d.languageType'))
                ->from('AppBundle:TypeUser', 'd')
                ->where(
                    $qb->expr()->gte('d.id', '1')
                )
                ->orderBy('d.createDate', 'DESC')
                ->getQuery();

            $typeUser = $q->getResult(Query::HYDRATE_ARRAY);
            foreach ($typeUser as $lang) {
                $languagesList[] = $lang['languageType'];
            }
            $languagesList = array_unique($languagesList);
            $languagesList= count($languagesList);
        }


        $em=$this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $q  = $qb->select(array('p'))
            ->from('AppBundle:Opinion', 'p')
            ->where(
                $qb->expr()->gte('p.id', '1')
            )
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        $opinions= $q->getResult();


        return $this->render('todo/index.html.twig',array(
            'todosCount' => $todosCount,
            'studentsCount' => $studentsCount,
            'languages' => $languagesList,
            'teachersCount' => $teachersCount,
            'opinions' => $opinions
        ));
    }


    /**
     * @Route("/logout",name="logout")
     */
    public function logoutAction()
    {
        $session = $this->get('session');
        $session->remove('user_id');
       // return $this->redirectToRoute('login');

    }
}
