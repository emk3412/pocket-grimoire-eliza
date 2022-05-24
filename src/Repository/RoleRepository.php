<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    public function getFeed(): array
    {

        return array_map(function (Role $role) {

            $feed = [
                'id' => $role->getIdentifier(),
                'name' => $role->getName(),
                'edition' => '',//$role->getEdition()->getIdentifier(),
                'team' => $role->getTeam()->getIdentifier(),
                'firstNight' => $role->getFirstNight(),
                'firstNightReminder' => $role->getFirstNightReminder(),
                'otherNight' => $role->getOtherNight(),
                'otherNightReminder' => $role->getOtherNightReminder(),
                'reminders' => $role->getReminders(),
                'setup' => $role->getSetup(),
                'ability' => $role->getAbility(),
                'image' => $role->getImage()
            ];

            if ($edition = $role->getEdition()) {
                $feed['edition'] = $edition->getIdentifier();
            }

            if (
                ($remindersGlobal = $role->getRemindersGlobal())
                && count($remindersGlobal)
            ) {
                $feed['remindersGlobal'] = $remindersGlobal;
            }

            return $feed;

        }, $this->findAll());

    }

}
