<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:58 PM
 */

namespace Admin\App\Controller;

use Admin\User\Entity\UserEntity;
use Admin\User\Form\UserForm;
use Admin\User\Service\UserService;
use Dot\AnnotatedServices\Annotation\Inject;
use Dot\AnnotatedServices\Annotation\Service;

/**
 * Class UserController
 * @package Dot\Authentication\Admin\Controller
 *
 * @Service
 */
class UserController extends EntityManageBaseController
{
    const ENTITY_NAME_SINGULAR = 'user';
    const ENTITY_NAME_PLURAL = 'users';
    const ENTITY_ROUTE_NAME = 'f_user';
    const ENTITY_TEMPLATE_NAME = 'user::user-table';

    const ENTITY_FORM_NAME = 'User';
    const ENTITY_DELETE_FORM_NAME = 'ConfirmDelete';
    const DEFAULT_SORTED_COLUMN = 'dateCreated';

    /**
     * UserController constructor.
     * @param UserService $service
     *
     * @Inject({UserService::class})
     */
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    /**
     * @param UserForm $form
     * @param UserEntity $entity
     * @param array $data
     */
    public function customizeEditValidation(UserForm $form, UserEntity $entity, array $data)
    {
        //make password field optional for updates if both are empty in the POST data
        if (empty($data['f_user']['password']) && empty($data['f_user']['passwordConfirm'])) {
            $form->disablePasswordValidation();
            $entity->needsPasswordRehash(false);
        }
    }
}