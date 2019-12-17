<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Constant;
use AppBundle\Entity\TypeUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query;

class TypeUserController extends Controller
{

    /**
     * @Route("{_locale}/teachers/{lang}", name="teachers")
     */
    public function teacherAction($lang)
    {
        $myDirectory = opendir($this->get('kernel')->getRootDir() ."/../images/flags");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension=explode('.',$entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);
        $i=0;
        $lang_array=array_flip(Constant::LANG_ARRAY);
        if($lang == 'all'){
            $teachersType=$this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType'=>'teacher'));
        }else{
            $teachersType=$this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType'=>'teacher',
                'languageType'=>$lang));
        }

        if(!empty($teachersType)) {
            foreach ($teachersType as $t) {
                $teacher = $this->getDoctrine()->getRepository('AppBundle:User')->find($t->getUserId());

                $teachers[$i]['name'] = $teacher->getUserName();
                $teachers[$i]['level'] = $t->getLanguageLevel();
                $teachers[$i]['userId'] = $t->getUserId();
                $teachers[$i]['language'] = array_search($t->getLanguageType(),$lang_array);
                $languageIcon=(in_array($t->getLanguageType(),$arrayFlags))?$t->getLanguageType().'.svg':'flag.png';
                $teachers[$i]['languageIcon'] = 'images/flags/'.$languageIcon ;
                $i++;
            }
        }else{
            $teachers=array();
        }
        return $this->render('teachers/index.html.twig', array(
            'teachers'=>$teachers
        ));


    }



    /**
     * @Route("{_locale}/students/{lang}", name="students")
     */
    public function studentAction($lang)
    {
        $myDirectory = opendir($this->get('kernel')->getRootDir() ."/../images/flags");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension=explode('.',$entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);
        $lang_array=array_flip(Constant::LANG_ARRAY);
        $i=0;
        if($lang == 'all'){
            $studentsType=$this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType'=>'student'));
        }else{
            $studentsType=$this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType'=>'student',
                'languageType'=>$lang));

        }
        if(!empty($studentsType)) {
            foreach ($studentsType as $t) {
                $student = $this->getDoctrine()->getRepository('AppBundle:User')->find($t->getUserId());
                $students[$i]['name'] = $student->getUserName();
                $students[$i]['level'] = $t->getLanguageLevel();
                $students[$i]['userId'] = $t->getUserId();
                $students[$i]['language'] = array_search($t->getLanguageType(),$lang_array);
                $languageIcon=(in_array($t->getLanguageType(),$arrayFlags))?$t->getLanguageType().'.svg':'flag.png';
                $students[$i]['languageIcon'] = 'images/flags/'. $languageIcon;
                $i++;
            }
        }else{
            $students=array();
        }
        return $this->render('students/index.html.twig', array(
            'students'=>$students
        ));
    }

    /**
     * @Route("{_locale}/students/ajax" , name="ajax")
     */
    public function ajaxAction(Request $request) {
        if($request->request->get('some_var_name')){
            //make something curious, get some unbelieveable data
            $arrData = ['output' => 'here the result which will appear in div'];
            return new JsonResponse($arrData);
        }
        return $this->render('students/ajax.html.twig');
    }



    /**
     * @Route("{_locale}/type/create", name="user_type_create")
     */
    public function createAction(Request $request)
    {

        $lang_array=array_flip(Constant::LANG_ARRAY);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $type_user = new TypeUser;
        $form=$this->createFormBuilder($type_user)
           ->add('user_type',ChoiceType::class,array('choices'=>array('Teacher'=>'teacher','Student'=>'student'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('language_type',ChoiceType::class,array('choices'=>$lang_array ,'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('language_level',ChoiceType::class,array('choices'=>array('Beginner'=>'beginner',
                'Middle'=>'middle',
                'Advanced'=>'advanced'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('is_available',CheckboxType::class,array('label'=>'Is available','required' => false,'attr'=>array('checked'   => 'checked','class'=>'btn btn-primary','style'=>'margin-left:5px;margin-bottom:5px;')))
            ->add('submit',SubmitType::class,array('label'=>'Register','attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px;')))

            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $language_type=$form['language_type']->getData();
            $language_level=$form['language_level']->getData();
            $user_type=$form['user_type']->getData();
            $is_available=$form['is_available']->getData();
            $now=new\DateTime('now');

            $type_user->setUserType($user_type);
            $type_user->setUserId($user->getId());
            $type_user->setLanguageType($language_type);
            $type_user->setLanguageLevel($language_level);
            if(!empty($is_available)){
                $type_user->setIsAvailable($is_available);
            }else{
                $type_user->setIsAvailable('N');
            }

            $type_user->setCreateDate($now);
            $type_user->setUpdatedAt($now);

            $em=$this->getDoctrine()->getManager();
            $em->persist($type_user);
            $em->flush();
            $this->addFlash('notice','Registered');
            //-- Update Redis language variable
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
            $redis_cluster = $this->container->get('snc_redis.default');
            if($redis_cluster->exists("count_languages")){
                $redis_cluster->del("count_languages");
            }
            $redis_cluster->set('count_languages',count($languagesList));
            return $this->redirectToRoute('list');
        }
        return $this->render('user_type/create.html.twig',array('form'=>$form->createView()));
    }


    /**
     * @Route("{_locale}/create_teacher", name="create_teacher")
     */
    public function createTeacherAction(Request $request)
    {
        $lang_array=array_flip(Constant::LANG_ARRAY);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $type_user = new TypeUser;
        $form=$this->createFormBuilder($type_user)
           ->add('user_type',ChoiceType::class,array('choices'=>array('Teacher'=>'teacher'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('language_type',ChoiceType::class,array('choices'=>$lang_array ,'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('language_level',ChoiceType::class,array('choices'=>array('Beginner'=>'beginner',
                'Middle'=>'middle',
                'Advanced'=>'advanced'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('is_available',CheckboxType::class,array('label'=>'Is available','required' => false,'attr'=>array('checked'   => 'checked','class'=>'btn btn-primary','style'=>'margin-left:5px;margin-bottom:5px;')))
            ->add('submit',SubmitType::class,array('label'=>'Register','attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px;')))

            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $language_type=$form['language_type']->getData();
            $language_level=$form['language_level']->getData();
            $user_type=$form['user_type']->getData();
            $is_available=$form['is_available']->getData();
            $now=new\DateTime('now');

            $type_user->setUserType($user_type);
            $type_user->setUserId($user->getId());
            $type_user->setLanguageType($language_type);
            $type_user->setLanguageLevel($language_level);
            if(!empty($is_available)){
                $type_user->setIsAvailable($is_available);
            }else{
                $type_user->setIsAvailable('N');
            }

            $type_user->setCreateDate($now);
            $type_user->setUpdatedAt($now);

            $em=$this->getDoctrine()->getManager();
            $em->persist($type_user);
            $em->flush();
            $this->addFlash('notice','Registered');

            //-- Update Redis language variable
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
            $redis_cluster = $this->container->get('snc_redis.default');
            //-- Set quantity of languages on website to Redis storage
            if($redis_cluster->exists("count_languages")){
                $redis_cluster->del("count_languages");
            }
            $redis_cluster->set('count_languages',count($languagesList));

            //-- Set quantity of teachers on website to Redis storage
            if($redis_cluster->exists("count_teachers")){
                $redis_cluster->del("count_teachers");
            }
            $teachers = $this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType' => 'teacher'));
            $teachersCount = count($teachers);
            $redis_cluster->set('count_teachers',$teachersCount);


            return $this->redirectToRoute('teachers', array('lang' => 'all'));
        }
        return $this->render('teachers/create.html.twig',array('form'=>$form->createView()));
    }

    /**
     * @Route("{_locale}/create_student", name="create_student")
     */
    public function createStudentAction(Request $request)
    {
        $lang_array=array_flip(Constant::LANG_ARRAY);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $type_user = new TypeUser;
        $form=$this->createFormBuilder($type_user)
           ->add('user_type',ChoiceType::class,array('choices'=>array('Student'=>'student'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('language_type',ChoiceType::class,array('choices'=>$lang_array ,'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('language_level',ChoiceType::class,array('choices'=>array('Beginner'=>'beginner',
                'Middle'=>'middle',
                'Advanced'=>'advanced'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('is_available',CheckboxType::class,array('label'=>'Is available','required' => false,'attr'=>array('checked'   => 'checked','class'=>'btn btn-primary','style'=>'margin-left:5px;margin-bottom:5px;')))
            ->add('submit',SubmitType::class,array('label'=>'Register','attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px;')))

            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $language_type=$form['language_type']->getData();
            $language_level=$form['language_level']->getData();

            $user_type=$form['user_type']->getData();
            $is_available=$form['is_available']->getData();
            $now=new\DateTime('now');

            $type_user->setUserType($user_type);
            $type_user->setUserId($user->getId());
            $type_user->setLanguageType($language_type);
            $type_user->setLanguageLevel($language_level);
            if(!empty($is_available)){
                $type_user->setIsAvailable($is_available);
            }else{
                $type_user->setIsAvailable('N');
            }

            $type_user->setCreateDate($now);
            $type_user->setUpdatedAt($now);

            $em=$this->getDoctrine()->getManager();
            $em->persist($type_user);
            $em->flush();
            $this->addFlash('notice','Registered');


            //-- Update Redis language variable
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
            $redis_cluster = $this->container->get('snc_redis.default');
            if($redis_cluster->exists("count_languages")){
                $redis_cluster->del("count_languages");
            }
            $redis_cluster->set('count_languages',count($languagesList));


            //-- Set quantity of students on website to Redis storage
            if($redis_cluster->exists("count_students")){
                $redis_cluster->del("count_students");
            }
            $students = $this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBY(array('userType' => 'student'));
            $studentsCount = count($students);
            $redis_cluster->set('count_students',$studentsCount);

            return $this->redirectToRoute('students', array('lang' => 'all'));
        }
        return $this->render('students/create.html.twig',array('form'=>$form->createView()));
    }

}
