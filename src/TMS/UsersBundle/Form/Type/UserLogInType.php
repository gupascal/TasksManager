<?php // src/TMS/UsersBundle/Form/Type/UserLogInType.php
namespace TMS\UsersBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserLogInType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
				->add('passwordHash', 'password')
				->add('save', 'submit');
    }

    public function getName()
    {
        return 'user_login';
    }
}