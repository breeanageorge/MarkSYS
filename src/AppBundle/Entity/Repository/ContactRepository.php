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

        //echo $dql;

        $query = $em->createQuery($dql);

        $records = $query->getResult();
        if ($records) {
            return $records[0];
        }

        return null;
    }

    public function updateIsRead($uuid)
    {
	$em = $this->getEntityManager();

        $dql = "SELECT c ";
        $dql .= "FROM " . Contact::class . " c ";
        $dql .= "WHERE c.isRead!='1' AND c.id = " . $uuid;

        $query = $em->createQuery($dql);

        $records = $query->getResult();
        if ($records) {
            $item = $em->getRepository(Contact::class)->find($uuid);

            if (!$item) {
                throw $this->createNotFoundException(
                    'No item found for id '
                );
            }

            $item->setIsRead('true');
            $em->flush();
	    return "true";
        }

        return "false";
    }
}
