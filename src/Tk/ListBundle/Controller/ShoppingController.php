<?php

namespace Tk\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tk\ListBundle\Entity\ShoppingItem;
use Tk\ListBundle\Form\ShoppingItemType;

class ShoppingController extends Controller
{
    public function newAction()
    {
    	$member = $this->getUser()->getCurrentMember();
    	$item = new ShoppingItem();
    	$item->setAuthor($member);
        $item->setGroup($member->getTGroup());
    	$item->setAddedDate(new \Datetime('now'));
    	$item->setActive(true);

    	$form = $this->createForm(new ShoppingItemType(), $item);

    	$request = $this->get('request');

        if ($request->isMethod('POST')) {
            
            $form->bind($request);

            if ($form->isValid()) {          
        
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($item);
    		$em->flush();

        	return $this->redirect($this->generateUrl('tk_list_homepage'));
    	}}

    	return $this->render('TkListBundle:Shopping:new.html.twig', array(
    		'form' => $form->createView(),
    	));
    }

    public function checkAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $item = $em->getRepository('TkListBundle:ShoppingItem')->find($id);

        $item->setActive(false);
        $item->setValidator($this->getUser()->getCurrentMember());
        $em->flush();

        return $this->redirect($this->generateUrl('tk_list_homepage'));
    }

    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $item = $em->getRepository('TkListBundle:ShoppingItem')->find($id);

        $em->remove($item);
        $em->flush();

        return $this->redirect($this->generateUrl('tk_list_homepage'));
    }

    public function reAddAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $item = $em->getRepository('TkListBundle:ShoppingItem')->find($id);

        $item2 = new ShoppingItem();
        $item2->setName($item->getName());
        $item2->setAuthor($this->getUser()->getCurrentMember());
        $item2->setGroup($item->getGroup());
        $item2->setAddedDate(new \Datetime('now'));
        $item2->setActive(true);

        $em->persist($item2);
        $em->flush();

        return $this->redirect($this->generateUrl('tk_list_homepage'));
    }

    public function receiveEmailAction()
    {
        $user = $this->getUser();
        $group = $user->getCurrentMember()->getTGroup();
        $shopping_list = $group->getActiveShoppingItems();
        
        $message = \Swift_Message::newInstance()
            ->setSubject('Your Shopping List from Twinkler !')
            ->setFrom('webmaster@twinkler.co')
            ->setTo($user->getEmail())
            ->setBody($this->renderView('TkListBundle:Shopping:shoppingListEmail.html.twig', array('user' => $user, 'shopping_list' => $shopping_list)))
        ;
        $this->get('mailer')->send($message);

        $url = $this->getRequest()->headers->get("referer");
        return $this->redirect($url);
    }
}