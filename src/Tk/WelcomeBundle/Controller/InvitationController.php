<?php

namespace Tk\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class InvitationController extends Controller
{
    public function chooseMemberAction($id, $token)
    {
        $group = $this->getDoctrine()->getRepository('TkGroupBundle:TGroup')->find($id);

        if ($token != $group->getInvitationToken()){
            throw new AccessDeniedException('You try to access a wrong Url');
        }else{

            return $this->render('TkWelcomeBundle:Invitation:chooseMember.html.twig', array(
                'group'   => $group,
                ));
        }
    }

    public function chosenMemberAction($id, $token)
    {
        $user = $this->getUser();
        $member = $this->getDoctrine()->getRepository('TkUserBundle:Member')->find($id);

        if ($token != $member->getInvitationToken()){
            throw new AccessDeniedException('The invitation has expired or the url is wrong');
        }else{

            if ($user){

                foreach($user->getMembers() as $user_member){
                    if ($user_member->getTGroup() == $member->getTGroup()){
                        throw new AccessDeniedException('You are already part of this group');
                    }
                }

                $member->setUser($user);
                $member->setInvitationToken(null);
                $user->setCurrentMember($member);
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($member);
                $em->flush();

                return $this->redirect($this->generateUrl('tk_expense_homepage'));

            }else{

                $this->get('session')->set('invitation_id', $id);
                return $this->render('TkWelcomeBundle:Invitation:login-invitation.html.twig', array(
                	'member' => $member
                	));

            }
        }
    }
}
