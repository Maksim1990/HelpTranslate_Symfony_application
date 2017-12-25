<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Constant;
use AppBundle\Entity\Todo;

use AppBundle\Entity\WorkStatus;
use Doctrine\ORM\Query;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TodoController extends Controller
{
    /**
     * @Route("{_locale}/", name="homepage")
     */
    public function homeAction(Request $request)
    {
        $locale = $request->getLocale();
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


        return $this->render('todo/index.html.twig', array(
            'todosCount' => $todosCount,
            'studentsCount' => $studentsCount,
            'languages' => $languagesList,
            'teachersCount' => $teachersCount,
            'opinions' => $opinions
        ));
    }


    /**
     * @Route("{_locale}/list", name="list")
     */
    public function listAction(Request $request)
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $q = $qb->select(array('p'))
            ->from('AppBundle:Todo', 'p')
            ->where(
                $qb->expr()->gte('p.id', '1')
            )
            ->orderBy('p.createDate', 'DESC')
            ->getQuery();

        $todos = $q->getResult(Query::HYDRATE_ARRAY);
        $i = 0;
        $userOnline = $this->get('security.token_storage')->getToken()->getUser();
        if ($todos) {
            foreach ($todos as $t) {

                if ($userOnline->getId() != $t['user_id']) {
                    $person = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('id' => $t['user_id']));

                    $works[$i]['user'] = $person->getUsername();
                    $works[$i]['id'] = $t['id'];
                    $works[$i]['description'] = $t['description'];
                    $works[$i]['title'] = $t['title'];
                    $works[$i]['dueDate'] = $t['dueDate']->format('Y-m-d H:i:s');
                    $works[$i]['userId'] = $t['user_id'];
                    $i++;
                }
            }
        } else {
            $works = array();
        }

        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $resultWorks = $paginator->paginate(
            $works,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );


        $myDirectory = opendir($this->get('kernel')->getRootDir() . "/../web/images/flags");
        while ($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension = explode('.', $entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);
        $j = 0;
        $lang_array = array_flip(Constant::LANG_ARRAY);
        $teachersType = $this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType' => 'teacher'));
        if (!empty($teachersType)) {
            foreach ($teachersType as $t) {
                $teacher = $this->getDoctrine()->getRepository('AppBundle:User')->find($t->getUserId());

                $teachers[$j]['name'] = $teacher->getUserName();
                $teachers[$j]['id'] = $t->getUserId();
                $teachers[$j]['language_level'] = $t->getLanguageLevel();
                $teachers[$j]['language'] = array_search($t->getLanguageType(), $lang_array);
                $languageIcon = (in_array($t->getLanguageType(), $arrayFlags)) ? $t->getLanguageType() . '.svg' : 'flag.png';
                $teachers[$j]['languageIcon'] = 'images/flags/' . $languageIcon;
                $j++;
            }
        } else {
            $teachers = array();
        }
        return $this->render('todo/list.html.twig', array(
            'todos' => $resultWorks,
            'teachers' => $teachers
        ));
    }


    /**
     * @Route("{_locale}/my_studying/{status}", name="my_studying_list")
     */
    public function myStudyingWorksAction($status = false, Request $request)
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();


        $q = $qb->select(array('p'))
            ->from('AppBundle:Todo', 'p')
            ->where(
                $qb->expr()->gte('p.id', '1')
            )
            ->orderBy('p.createDate', 'DESC')
            ->getQuery();

        $todos = $q->getResult(Query::HYDRATE_ARRAY);
        $i = 0;
        $userOnline = $this->get('security.token_storage')->getToken()->getUser();
        $works = array();
        if ($todos) {
            foreach ($todos as $t) {
//            $users= $qb->select(array('u'.$t['id']))
//                ->from('AppBundle:User', 'u'.$t['id'])
//                ->where(
//                    $qb->expr()->gt('u'.$t['id'].'.id', $t['user_id'])
//                )
//                ->getQuery()->getResult(Query::HYDRATE_ARRAY);
                if ($userOnline->getId() == $t['user_id']) {
                    $person = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('id' => $t['user_id']));
                    if (!$status) {
                        $workStatus = $this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId' => $t['id']));

                        if ($workStatus) {
                            $teacher = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('id' => $workStatus->getUserReviewerId()));
                            $works[$i]['teacher_name'] = $teacher->getUsername();
                            $works[$i]['teacher_id'] = $teacher->getId();
                            $works[$i]['teacher_status'] = $workStatus->getWorkStatus();
                        } else {
                            $arrTest = [];
                        }
                        $works[$i]['user'] = $person->getUsername();
                        $works[$i]['id'] = $t['id'];
                        $works[$i]['description'] = $t['description'];
                        $works[$i]['language_type'] = $t['languageType'];
                        $works[$i]['title'] = $t['title'];
                        $works[$i]['dueDate'] = $t['dueDate']->format('Y-m-d H:i:s');
                        $works[$i]['createdDate'] = $t['createDate']->format('Y-m-d H:i:s');
                        $works[$i]['userId'] = $t['user_id'];
                        $i++;

                    } elseif (strtolower($status == 'pending') || strtolower($status == 'declined') || strtolower($status == 'accepted')) {
                        $workStatus = $this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId' => $t['id'],
                            'workStatus' => ucfirst($status)));

                        if ($workStatus) {
                            $teacher = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('id' => $workStatus->getUserReviewerId()));
                            $works[$i]['teacher_name'] = $teacher->getUsername();
                            $works[$i]['teacher_id'] = $teacher->getId();
                            $works[$i]['teacher_status'] = $workStatus->getWorkStatus();
                            $works[$i]['user'] = $person->getUsername();
                            $works[$i]['id'] = $t['id'];
                            $works[$i]['description'] = $t['description'];
                            $works[$i]['language_type'] = $t['languageType'];
                            $works[$i]['title'] = $t['title'];
                            $works[$i]['dueDate'] = $t['dueDate']->format('Y-m-d H:i:s');
                            $works[$i]['createdDate'] = $t['createDate']->format('Y-m-d H:i:s');
                            $works[$i]['userId'] = $t['user_id'];
                            $i++;
                        }

                    } elseif ($status == 'draft') {
                        $workStatus = $this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId' => $t['id']));
                        if (!$workStatus) {
                            $works[$i]['user'] = $person->getUsername();
                            $works[$i]['id'] = $t['id'];
                            $works[$i]['description'] = $t['description'];
                            $works[$i]['language_type'] = $t['languageType'];
                            $works[$i]['title'] = $t['title'];
                            $works[$i]['dueDate'] = $t['dueDate']->format('Y-m-d H:i:s');
                            $works[$i]['createdDate'] = $t['createDate']->format('Y-m-d H:i:s');
                            $works[$i]['userId'] = $t['user_id'];
                        } else {
                            $arrTest = [];
                        }
                        $i++;
                    }
                }
            }
        }

        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $resultWorks = $paginator->paginate(
            $works,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );


        $myDirectory = opendir($this->get('kernel')->getRootDir() . "/../web/images/flags");
        while ($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension = explode('.', $entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);
        $j = 0;
        $lang_array = array_flip(Constant::LANG_ARRAY);
        $teachersType = $this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType' => 'teacher'));
        if (!empty($teachersType)) {
            foreach ($teachersType as $t) {
                $teacher = $this->getDoctrine()->getRepository('AppBundle:User')->find($t->getUserId());

                if ($teacher->getId() != $userOnline->getId()) {
                    $teachers[$j]['name'] = $teacher->getUserName();
                    $teachers[$j]['id'] = $t->getUserId();
                    $teachers[$j]['language_level'] = $t->getLanguageLevel();
                    $teachers[$j]['language'] = array_search($t->getLanguageType(), $lang_array);
                    $languageIcon = (in_array($t->getLanguageType(), $arrayFlags)) ? $t->getLanguageType() . '.svg' : 'flag.png';
                    $teachers[$j]['languageIcon'] = 'images/flags/' . $languageIcon;
                }
                $j++;
            }
        } else {
            $teachers = array();
        }


        $myDirectory = opendir($this->get('kernel')->getRootDir() . "/../web/images/flags");
        while ($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension = explode('.', $entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);

        if (!$status) {
            $status = 'studying';
        }
        return $this->render('todo/my_studying_works.html.twig', array(
            'todos' => $resultWorks,
            'teachers' => $teachers,
            'arrayFlags' => $arrayFlags,
            'status' => $status
        ));
    }


    /**
     * @Route("{_locale}/list_teaching/{status}", name="list_teaching")
     */
    public function listTeachingAction($status = false, Request $request)
    {
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();


        $q = $qb->select(array('p'))
            ->from('AppBundle:Todo', 'p')
            ->where(
                $qb->expr()->gte('p.id', '1')
            )
            ->orderBy('p.createDate', 'DESC')
            ->getQuery();

        $todos = $q->getResult(Query::HYDRATE_ARRAY);
        $i = 0;
        $userOnline = $this->get('security.token_storage')->getToken()->getUser();
        $works = array();
        if ($todos) {
            foreach ($todos as $t) {
//            $users= $qb->select(array('u'.$t['id']))
//                ->from('AppBundle:User', 'u'.$t['id'])
//                ->where(
//                    $qb->expr()->gt('u'.$t['id'].'.id', $t['user_id'])
//                )
//                ->getQuery()->getResult(Query::HYDRATE_ARRAY);

                $person = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('id' => $t['user_id']));
                if (!$status) {
                    $workStatus = $this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId' => $t['id']));
                    $reviewerId = $workStatus ? $workStatus->getUserReviewerId() : null;
                } elseif (strtolower($status == 'pending') || strtolower($status == 'declined') || strtolower($status == 'accepted')) {
                    $workStatus = $this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId' => $t['id'],
                        'workStatus' => ucfirst($status)));
                    $reviewerId = $workStatus ? $workStatus->getUserReviewerId() : null;
                }

                if (isset($workStatus) && $reviewerId == $userOnline->getId()) {
                    $works[$i]['user'] = $person->getUsername();
                    $works[$i]['work_status'] = $workStatus->getWorkStatus();
                    $works[$i]['id'] = $t['id'];
                    $works[$i]['description'] = $t['description'];
                    $works[$i]['language_type'] = $t['languageType'];
                    $works[$i]['title'] = $t['title'];
                    $works[$i]['dueDate'] = $t['dueDate']->format('Y-m-d H:i:s');
                    $works[$i]['createdDate'] = $t['createDate']->format('Y-m-d H:i:s');
                    $works[$i]['userId'] = $t['user_id'];
                    $i++;
                }
            }
        }

        /**
         * @var $paginator Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $resultWorks = $paginator->paginate(
            $works,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );


        $myDirectory = opendir($this->get('kernel')->getRootDir() . "/../web/images/flags");
        while ($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension = explode('.', $entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);
        $j = 0;
        $lang_array = array_flip(Constant::LANG_ARRAY);


        $myDirectory = opendir($this->get('kernel')->getRootDir() . "/../web/images/flags");
        while ($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension = explode('.', $entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);

        if (!$status) {
            $status = '';
        }
        return $this->render('todo/list_teaching.html.twig', array(
            'todos' => $resultWorks,
            'arrayFlags' => $arrayFlags,
            'status' => $status
        ));
    }


    /**
     * @Route("{_locale}/todo/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $todo = new Todo;
        $lang_array = array_flip(Constant::LANG_ARRAY);
        $form = $this->createFormBuilder($todo)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;')))
            ->add('category', ChoiceType::class, array('choices' => array('Text' => 'text', 'Article' => 'article'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;width:25%;')))
            ->add('language_type', ChoiceType::class, array('choices' => $lang_array, 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;width:25%;')))
            ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal' => 'Normal', 'High' => 'High'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;width:25%;')))
            ->add('description', CKEditorType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;')))
            ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px;')))
            ->add('submit', SubmitType::class, array('label' => 'Create work', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px;')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form['title']->getData();
            $category = $form['category']->getData();
            $language_type = $form['language_type']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();
            $now = new\DateTime('now');

            $todo->setTitle($title);
            $todo->setUserId($user->getId());
            $todo->setCategory($category);
            $todo->setLanguageType($language_type);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);
            $todo->setUpdatedAt($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            $this->addFlash('notice', 'Task added');

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

            //-- Set quantity of works on website to Redis storage
            if($redis_cluster->exists("count_works")){
                $redis_cluster->del("count_works");
            }
            $todoAll = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();
            $todoCount = count($todoAll);
            $redis_cluster->set('count_works',$todoCount);


            return $this->redirectToRoute('my_studying_list');
        }
        return $this->render('todo/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("{_locale}/todo/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->find($id);
        $lang_array = array_flip(Constant::LANG_ARRAY);
        $todo->setTitle($todo->getTitle());
        $todo->setCategory($todo->getCategory());
        $todo->setLanguageType($todo->getLanguageType());
        $todo->setDescription($todo->getDescription());
        $todo->setPriority($todo->getPriority());
        $todo->setDueDate($todo->getDueDate());
        $form = $this->createFormBuilder($todo)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;')))
            ->add('category', ChoiceType::class, array('choices' => array('Text' => 'text', 'Article' => 'article'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;width:25%;')))
            ->add('language_type', ChoiceType::class, array('choices' => $lang_array, 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;width:25%;')))
            ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal' => 'Normal', 'High' => 'High'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;width:25%;')))
            ->add('description', CKEditorType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px;')))
            ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px;')))
            ->add('submit', SubmitType::class, array('label' => 'Update work', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px;')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form['title']->getData();
            $todo->setUserId($user->getId());
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $language_type = $form['language_type']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();
            $now = new\DateTime('now');

            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('AppBundle:Todo')->find($id);
            $todo->setTitle($title);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setLanguageType($language_type);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setUpdatedAt($now);

            $em = $this->getDoctrine()->getManager();

            $em->flush();
            $this->addFlash('notice', 'Task updated');


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

            //-- Update count_languages
            if($redis_cluster->exists("count_languages")){
                $redis_cluster->del("count_languages");
            }
            $redis_cluster->set('count_languages',count($languagesList));
            //-- Set quantity of works on website to Redis storage
            if($redis_cluster->exists("count_works")){
                $redis_cluster->del("count_works");
            }
            $todoAll = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();
            $todoCount = count($todoAll);
            $redis_cluster->set('count_works',$todoCount);

            return $this->redirectToRoute('my_studying_list');
        }
        return $this->render('todo/edit.html.twig', array(
            'todo' => $todo,
            'form' => $form->createView()));
    }

    /**
     * @Route("{_locale}/todo/detail/{id}/{list}", name="todo_detail")
     */
    public function detailAction($id, $list = false)
    {
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->find($id);

        $status = $this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId' => $todo->getId()));

        $workStatus = $status ? $status->getWorkStatus() : 'Undefined';

        return $this->render('todo/details.html.twig', array('todo' => $todo, 'list' => $list, 'status' => $workStatus));
    }

    /**
     * @Route("{_locale}/todo/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository('AppBundle:Todo')->find($id);

        $em->remove($todo);
        $em->flush();
        $this->addFlash('notice', 'Task deleted');

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

        //-- Update count_languages
        if($redis_cluster->exists("count_languages")){
            $redis_cluster->del("count_languages");
        }
        $redis_cluster->set('count_languages',count($languagesList));
        //-- Set quantity of works on website to Redis storage
        if($redis_cluster->exists("count_works")){
            $redis_cluster->del("count_works");
        }
        $todoAll = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();
        $todoCount = count($todoAll);
        $redis_cluster->set('count_works',$todoCount);

        return $this->redirectToRoute('list');

    }


    /**
     * @Route("{_locale}/assign_user_to_task/ajax" , name="assign_user_to_task_ajax")
     */
    public function ajaxAssignTeacherAction(Request $request)
    {
        if ($work_id = $request->request->get('work_id')) {
            $workStatus = $this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId' => $work_id));
            if (!isset($workStatus)) {
                $workStatus = new WorkStatus;
            }
            $user_reviewer_id = $request->request->get('user_reviewer_id');
            $now = new\DateTime('now');

            $workStatus->setWorkId($work_id);
            $workStatus->setUserReviewerId($user_reviewer_id);
            $workStatus->setWorkType('Text');
            $workStatus->setWorkStatus('Pending');
            $workStatus->setCreatedAt($now);
            $workStatus->setUpdatedAt($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($workStatus);
            $em->flush();

            $arrData = ['output' => 'true'];
            return new JsonResponse($arrData);
        }
    }

    /**
     * @Route("{_locale}/unassign_teacher_ajax" , name="unassign_teacher_ajax")
     */
    public function ajaxUnAssignTeacherAction(Request $request)
    {
        if ($work_id = $request->request->get('work_id')) {
            $workStatus = $this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId' => $work_id));
            $em = $this->getDoctrine()->getManager();
            $em->remove($workStatus);
            $em->flush();
            $arrData = ['output' => 'true'];
            return new JsonResponse($arrData);
        }
    }


}
