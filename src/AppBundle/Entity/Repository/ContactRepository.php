<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Contact;
use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{
    public function findAllRecords($new = false)
    {
        $em = $this->getEntityManager();

        $dql = "SELECT c ";
        $dql .= "FROM " . Contact::class . " c ";
        if ($new) {
            $dql .= "WHERE c.isRead = false";
        }

        $query = $em->createQuery($dql);

        return $query;
    }

    public function loadRecord($uuid)
    {
        $em = $this->getEntityManager();

        $dql = "SELECT c ";
        $dql .= "FROM " . Contact::class . " c ";
        $dql .= "WHERE c.id = " . $uuid;

        $query = $em->createQuery($dql);

        $records = $query->getResult();
        if ($records) {
            return $records[0];
        }

        return null;
    }
}