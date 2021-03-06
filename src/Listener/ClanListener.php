<?php

namespace App\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\Clan\ClanProposition;
 
class ClanListener
{

    // supprime les propositions
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Clan)
        {
            $em = $args->getEntityManager();

            $membres = $entity->getMembres();
            if($membres){
                $repo_proposition = $em->getRepository(ClanProposition::class);
                foreach($membres as $membre){
                    // supprime les propositions de recrutement
                    $propositions = $repo_proposition->getPropositionByRecruteur($membre);
                    if($propositions){
                        foreach($propositions as $proposition){
                            $em->remove($proposition);
                        }
                    }
                }
                $em->flush();
            }
        }
    }
}