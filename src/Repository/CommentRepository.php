<?php
namespace App\Repository;
 
use Doctrine\ORM\EntityRepository;
use App\Entity\Forum\Forum;
use App\Entity\Forum\Thread;
use App\Entity\User\User;
 
class CommentRepository extends EntityRepository
{
    public function getCommentsByThread(Thread $thread, $nombreParPage=5, $page=1)
    {
        $page = max(1, $page);

        $query = $this->createQueryBuilder('c')
            ->where('c.thread = :thread')
            ->setParameter('thread', $thread)
            ->addOrderBy('c.dateAjout', 'DESC')
            ->getQuery();

        $query->setFirstResult(($page-1) * $nombreParPage)
            ->setMaxResults($nombreParPage);

        return $query->getResult();
    }

    public function getRecentComments(Forum $forum = null, User $user = null, $num = 0)
    {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.dateAjout', 'DESC');

        if(!empty($forum)){
            $query->leftJoin('App\Entity\Forum\Thread', 't', 'WITH', 'c.thread = t.id')
                ->andWhere('t.forum = :forum')
                ->setParameter('forum', $forum);
        }
        if(!empty($user)){
            $query->andWhere('c.author = :user')
                ->setParameter('user', $user);
        }
        $query->setFirstResult(0)
            ->setMaxResults($num);

        return $query->getQuery()->getResult();
    }

    public function getCommentsByAuthor(User $user, $nombreParPage=10, $page=1)
    {
        $page = max(1, $page);

        $query = $this->createQueryBuilder('c')
            ->where('c.author = :user')
            ->setParameter('user', $user)
            ->addOrderBy('c.dateAjout', 'DESC');

        $query->setFirstResult(($page-1) * $nombreParPage)
            ->setMaxResults($nombreParPage);

        return $query->getQuery()->getResult();
    }

    public function searchComments(User $user=null, Forum $forum=null, $q = "", $nombreParPage=5, $page=1)
    {
        $query = $this->createQueryBuilder('c')
            ->addOrderBy('c.dateAjout', 'DESC');

        if(!empty($q)){
            $query->andWhere('c.body LIKE :q')
            ->setParameter('q', '%'.$q.'%');
        }

        if(isset($user)){
            $query->andWhere('c.author = :user')
            ->setParameter('user', $user);
        }

        if(isset($forum)){
            $query->innerJoin('App\Entity\Forum\Thread', 't', 'WITH', 'c.thread = t.id')
                ->andWhere('t.forum = :forum')
                ->setParameter('forum', $forum);
        }

        $query->setFirstResult(($page-1) * $nombreParPage)
            ->setMaxResults($nombreParPage);

        return $query->getQuery()->getResult();
    }

    public function deleteCommentsByThread(Thread $thread = null)
    {
        if($thread){
            $query = $this->createQueryBuilder('c')
                ->delete('App\Entity\Forum\Comment', 'c')
                ->where('c.thread = :thread')
                ->setParameter('thread', $thread)
                ->getQuery();
     
            return 1 === $query->getScalarResult();
        }
        return false;
    }
}