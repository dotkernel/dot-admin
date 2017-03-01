<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 7:54 PM
 */

declare(strict_types = 1);

namespace Admin\User;

use Admin\User\Entity\UserEntity;
use Admin\User\Form\UserDetailsFieldset;
use Admin\User\Form\UserFieldset;
use Admin\User\Form\UserForm;
use Admin\User\Mapper\UserDbMapper;
use Dot\User\Factory\UserDbMapperFactory;
use Dot\User\Factory\UserFieldsetFactory;
use Zend\Form\ElementFactory;

/**
 * Class ConfigProvider
 * @package Admin\User
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),

            'dot_form' => $this->getFormsConfig(),

            'dot_ems' => $this->getMappersConfig(),
        ];
    }

    public function getDependenciesConfig(): array
    {
        return [

        ];
    }

    public function getFormsConfig(): array
    {
        return [
            'form_manager' => [
                'factories' => [
                    UserFieldset::class => UserFieldsetFactory::class,
                    UserDetailsFieldset::class => ElementFactory::class,
                    UserForm::class => ElementFactory::class,
                ],
                'aliases' => [
                    'F_UserFieldset' => UserFieldset::class,
                    'F_UserDetailsFieldset' => UserDetailsFieldset::class,
                    'User' => UserForm::class,
                ]
            ]
        ];
    }

    public function getMappersConfig(): array
    {
        return [
            'mapper_manager' => [
                'factories' => [
                    UserDbMapper::class => UserDbMapperFactory::class,
                ],
                'aliases' => [
                    UserEntity::class => UserDbMapper::class,
                ]
            ]
        ];
    }
}
