<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Instructeur;
use AppBundle\Entity\Member;
use Doctrine\ORM\EntityRepository;

/**
 * LessonRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class LessonRepository extends EntityRepository
{
    /**
     * @return Lesson[]
     */
    public function verkrijgLesAanbodBezoeker()
    {
        $em = $this->getEntityManager();
        $query=$em->createQuery("SELECT d FROM AppBundle:Lesson d WHERE CURRENT_TIMESTAMP() < d.date");
        return $query->getResult();
    }

    /**
     * @return Lesson[]
     */
    public function verkrijgNietGeregistreerdeLessen(Member $member)
    {
        $em = $this->getEntityManager();
        return $this->createQueryBuilder('l')
            ->select("l.registrations", "r")
            ->where("CURRENT_TIMESTAMP() < l.date")
            ->getQuery()
            ->getResult()
        ;

        //$query=$em->createQuery("SELECT d FROM AppBundle:Lesson d, AppBundle:Registration r WHERE CURRENT_TIMESTAMP() < d.date AND (r.lesson = d AND NOT MEMBER of r.member = :member)");
        //$query->setParameter('member', $member);
//        return $query->getResult();
    }

    /**
     * @return Lesson[]
     */
    public function verkrijgGeregistreerdeLessen(Member $member)
    {
        $em = $this->getEntityManager();
        $query=$em->createQuery("SELECT d FROM AppBundle:Lesson d, AppBundle:Registration r WHERE CURRENT_TIMESTAMP() < d.date AND r.lesson = d AND r.member = :member");
        $query->setParameter('member', $member);
        return $query->getResult();
    }
}
