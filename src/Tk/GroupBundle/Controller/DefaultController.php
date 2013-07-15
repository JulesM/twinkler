<?php

namespace Tk\GroupBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\GroupBundle\Entity\TGroup;
use Tk\GroupBundle\Form\TGroupType;
use Tk\UserBundle\Entity\Member;


class DefaultController extends Controller
{
    public function indexAction()
    {
        if(!$this->getUser()->getCurrentMember()){
            return $this->redirect($this->generateUrl('tk_user_homepage'));
        }else{
            return $this->render('TkGroupBundle:Default:settings.html.twig');
        }
    }

    public function switchAction($id)
    {
    	$this->changeCurrentMemberAction($id);

        $route = $this->get('request')->get('route');
        return $this->redirect($this->generateUrl($route));
    }

    public function goToAction($id)
    {
        $this->changeCurrentMemberAction($id);

        return $this->redirect($this->generateUrl('tk_group_homepage'));
    }

    public function goToExpensesAction($id)
    {
        $this->changeCurrentMemberAction($id);

        return $this->redirect($this->generateUrl('tk_expense_homepage'));
    }

    public function goToListsAction($id)
    {
        $this->changeCurrentMemberAction($id);

        return $this->redirect($this->generateUrl('tk_list_homepage'));
    }

    private function changeCurrentMemberAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $member = $em->getRepository('TkUserBundle:Member')->find($id);
        $user = $this->getUser();
        $user->setCurrentMember($member);
        $em->flush();
    }

    public function newAction()
    {
        $group = new TGroup();
        $group->setDate(new \Datetime('now'));

        $form = $this->createForm(new TGroupType(), $group);

        $request = $this->get('request');

        if ($request->isMethod('POST')) {

            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();

                $user = $this->getUser();
                $member = new Member();
                $member->setUser($user);
                $member->setName($user->getUsername());
                $member->setTGroup($group);
                $user->setCurrentMember($member);
                $group->setInvitationToken($group->generateInvitationToken());
                $em->persist($group);
                $em->persist($member);
                $em->flush();

                return $this->redirect($this->generateUrl('tk_group_add_members'));
            }
        }

        return $this->render('TkGroupBundle:Creation:new.html.twig', array(
            'form' => $form->createView(),
            ));        
    }

    public function editAction()
    {
        $group = $this->getUser()->getCurrentMember()->getTGroup();

        $form = $this->createForm(new TGroupType(), $group);

        $request = $this->get('request');

        if ($request->isMethod('POST')) {

            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($group);
                $em->flush();

                return $this->redirect($this->generateUrl('tk_group_homepage'));
            }
        }

        return $this->render('TkGroupBundle:GroupActions:edit.html.twig', array(
            'form' => $form->createView(),
            ));        
    }

    public function addMemberAction()
    {   
        $defaultData = array('name' => '', 'email' => '');
        $form = $this->createFormBuilder($defaultData)
            ->add('name', 'text')
            ->add('email', 'email', array(
                'required' => false
                ))
            ->getForm();

        $request = $this->get('request');

        if ($request->isMethod('POST')) {

            $form->bind($request);

            if ($form->isValid()) {

            $data = $form->getData();
            $member = new Member();
            $member->setName($data['name']);
            $member->setEmail($data['email']);
            $member->setInvitationToken($member->generateInvitationToken());
            $member->setTGroup($this->getUser()->getCurrentMember()->getTGroup());

            if($data['email']){
                $message = \Swift_Message::newInstance()
                            ->setSubject('You received an invitation to join Twinkler !')
                            ->setFrom(array('jules@twinkler.co' => 'Jules from Twinkler'))
                            ->setTo($data['email'])
                            ->setContentType('text/html')
                            ->setBody($this->renderView(':emails:invitationEmail.email.twig', array('member' => $this->getUser()->getCurrentMember(), 'email' => $data['email'])))
                        ;
                $this->get('mailer')->send($message);
            }

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($member);
            $em->flush();

            $url = $this->getRequest()->headers->get("referer");
            return $this->redirect($url);
        }}

        return $this->render('TkGroupBundle:GroupActions:addMember.html.twig', array(
            'form' => $form->createView(),
            ));        
    }

    public function addMembersAction()
    {   
        return $this->render('TkGroupBundle:Creation:addMembers.html.twig');      
    }

    public function removeMemberRequestAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $member = $em->getRepository('TkUserBundle:Member')->find($id);

        if ($this->getUser()->getCurrentMember()->getTGroup() != $member->getTGroup()){
            throw new AccessDeniedException('You are not allowed to do this');
        }else{
            $this->removeMemberAction($member, $em);
            return $this->redirect($this->generateUrl('tk_group_homepage'));
        }
    }

    private function removeMemberAction($member, $em)
    {
        $all_todos = $member->getTGroup()->getTodos();
        $todos_number = 0;
        foreach($all_todos as $todo){
            if($todo->getOwner() == $member or $todo->getAuthor() == $member){
                $todos_number = 1;
                break;
            }
            if($todos_number == 1){
                break;
            }
        }

        $all_items = $member->getTGroup()->getShoppingItems();
        $items_number = 0;
        foreach($all_items as $item){
            if($item->getAuthor() == $member or $item->getValidator() == $member){
                $items_number = 1;
                break;
            }
        }
        if($member->getUser()){
            $member->getUser()->setCurrentMember(null);
        }
        $n = sizeof($member->getMyExpenses()) + sizeof($member->getForMeExpenses()) + $todos_number + $items_number;
        if ($n == 0){
            $em->remove($member);
        }else{
            $member->setActive(false);
        }
        $em->flush();
    }

    public function closeGroupAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $group = $em->getRepository('TkGroupBundle:TGroup')->find($id);

        if ($this->getUser()->getCurrentMember()->getTGroup() != $group){
            throw new AccessDeniedException('You are not allowed to do this');
        }
        else{
            foreach($group->getMembers() as $member){
                $this->removeMemberAction($member, $em);
            }               
        }
        return $this->redirect($this->generateUrl('tk_user_homepage')); 
    }

    public function sendInvitationAction()
    {
        return $this->render('TkGroupBundle:Creation:sendInvitations.html.twig');
    }

    public function inviteUserAction()
    {
        return $this->render('TkGroupBundle:GroupActions:inviteUser.html.twig');
    }

    public function sendInvitationEmailAction()
    {
        $member = $this->getUser()->getCurrentMember();

        $defaultData = array('email' => '');
        $form = $this->createFormBuilder($defaultData)
            ->add('email', 'email', array('attr' => array('placeholder' => 'Email',)))
            ->getForm();

        $request = $this->get('request');

        if ($request->isMethod('POST')) {

            $form->bind($request);

            if ($form->isValid()) {

            $data = $form->getData();

            $message = \Swift_Message::newInstance()
                        ->setSubject('You received an invitation to join Twinkler !')
                        ->setFrom(array('jules@twinkler.co' => 'Jules from Twinkler'))
                        ->setTo($data['email'])
                        ->setContentType('text/html')
                        ->setBody($this->renderView(':emails:invitationEmail.email.twig', array('member' => $member, 'email' => $data['email'])))
                    ;
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('tk_group_homepage'));
        }}

        return $this->render('TkGroupBundle:GroupActions:sendEmailForm.html.twig', array(
            'form' => $form->createView(),
            ));
    }

    public function sendReminderEmailAction()
    {

    }
}
