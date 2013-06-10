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
        return $this->render('TkGroupBundle:Default:index.html.twig');
    }

    public function switchAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$member = $em->getRepository('TkUserBundle:Member')->find($id);
    	$user = $this->getUser();
    	$user->setCurrentMember($member);

    	$em->flush();

        $route = $this->get('request')->get('route');
        return $this->redirect($this->generateUrl($route));
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
                $group->setInvitationToken($group->generateInvitationToken());
                $em->persist($group);
                $em->persist($member);
                $em->flush();

                return $this->redirect($this->generateUrl('tk_group_add_members'));
            }
        }

        return $this->render('TkGroupBundle:Default:new.html.twig', array(
            'form' => $form->createView(),
            ));        
    }

    public function addMembersAction()
    {   
        $defaultData = array('name' => '');
        $form = $this->createFormBuilder($defaultData)
            ->add('name', 'text')
            ->getForm();

        $request = $this->get('request');

        if ($request->isMethod('POST')) {

            $form->bind($request);

            if ($form->isValid()) {

            $data = $form->getData();
            $member = new Member();
            $member->setName($data['name']);
            $member->setTGroup($this->getUser()->getCurrentMember()->getTGroup());

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($member);
            $em->flush();

            return $this->redirect($this->generateUrl('tk_group_add_members_success', array( 'id' => $member->getId())));
        }}

        return $this->render('TkGroupBundle:Default:addMembers.html.twig', array(
            'form' => $form->createView(),
            ));        
    }

    public function inviteUserAction($id)
    {
        $member = $this->getDoctrine()->getRepository('TkUserBundle:Member')->find($id);
        return $this->render('TkGroupBundle:Default:inviteUser.html.twig', array(
                        'member' => $member,
                    ));
    }

    public function sendInvitationEmailAction($id)
    {
        $member1 = $this->getUser()->getCurrentMember();
        $member2 = $this->getDoctrine()->getRepository('TkUserBundle:Member')->find($id);
        $member2->setInvitationToken($member2->generateInvitationToken());

        $defaultData = array('email' => '');
        $form = $this->createFormBuilder($defaultData)
            ->add('email', 'email')
            ->getForm();

        $request = $this->get('request');

        if ($request->isMethod('POST')) {

            $form->bind($request);

            if ($form->isValid()) {

            $data = $form->getData();

            $message = \Swift_Message::newInstance()
                        ->setSubject('You received an invitation to join Twinkler !')
                        ->setFrom('jules@twinkler.co')
                        ->setTo($data['email'])
                        ->setBody($this->renderView('TkGroupBundle:Default:invitationEmail.html.twig', array('member1' => $member1, 'member2' => $member2, 'email' => $data['email'])))
                    ;
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('tk_group_add_members'));
        }}

        return $this->render('TkGroupBundle:Default:sendEmailForm.html.twig', array(
            'form' => $form->createView(),
            'id'   => $id,
            ));
    }
}
