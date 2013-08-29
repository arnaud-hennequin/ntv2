<?php

namespace NinjaTooken\UserBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use NinjaTooken\UserBundle\Entity\Ip;
use NinjaTooken\UserBundle\Entity\User;

class LoginListener
{
    private $securityContext;
    private $em;

    /**
    * Constructor
    * 
    * @param SecurityContext $context
    * @param Doctrine        $doctrine
    */
    public function __construct( SecurityContext $securityContext , Doctrine $doctrine )
    {
        $this->securityContext = $securityContext;
        $this->em = $doctrine->getEntityManager();
    }

    /**
    * Do the magic.
    *
    * @param InteractiveLoginEvent $event
    */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY') || $this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $event->getAuthenticationToken()->getUser();
            $request = $event->getRequest();

            $currentIp = ip2long($request->getClientIp());

            $ip = $this->em->getRepository('NinjaTookenUserBundle:Ip')
                ->findOneBy(array('ip' => $currentIp, 'user' => $user));

            if(!$ip){
                $ip = new Ip();
                $ip->setIp($currentIp);
                $ip->setUser($user);
            }
            $ip->setUpdatedAt(new \DateTime());

            $this->em->persist($ip);
            $this->em->flush();
        }
    }
}