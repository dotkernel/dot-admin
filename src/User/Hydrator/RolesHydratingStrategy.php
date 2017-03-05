<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/4/2017
 * Time: 11:58 PM
 */

declare(strict_types = 1);

namespace Admin\User\Hydrator;

use Admin\App\Exception\RuntimeException;
use Dot\AnnotatedServices\Annotation\Service;
use Dot\Ems\Mapper\MapperInterface;
use Dot\Ems\Mapper\MapperManagerAwareInterface;
use Dot\Ems\Mapper\MapperManagerAwareTrait;
use Dot\User\Entity\RoleEntity;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class RolesHydratingStrategy
 * @package Admin\Admin\Hydrator
 *
 * @Service
 */
class RolesHydratingStrategy implements StrategyInterface, MapperManagerAwareInterface
{
    use MapperManagerAwareTrait;

    /**
     * @param mixed $value
     * @return array
     */
    public function hydrate($value)
    {
        /** @var MapperInterface $mapper */
        $mapper = $this->getMapperManager()->get(RoleEntity::class);
        $identifier = current($mapper->getPrimaryKey());

        $roles = [];
        $roleIds = [];

        // if value is an array of role ids, replace them with RoleEntity instances
        $value = (array) $value;
        foreach ($value as $role) {
            if ($role instanceof RoleEntity) {
                $roles[] = $role;
                continue;
            }

            if (is_string($role) || is_numeric($role)) {
                $roleIds[] = (int) $role;
            }
        }

        if (!empty($roleIds)) {
            $collectedRoles = $mapper->find('all', ['conditions' => [$identifier => $roleIds]]);
            $roles = array_merge($roles, $collectedRoles);
        }

        if (count($roles) !== count($value)) {
            throw new RuntimeException('Could not load all roles for entity');
        }

        return $roles;
    }

    public function extract($value)
    {
        // no need for extract strategy in this case
        return $value;
    }
}
