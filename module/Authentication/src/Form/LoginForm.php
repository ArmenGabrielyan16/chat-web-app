<?php

namespace Authentication\Form;

use Main\Form\FormBase;

/**
 * Class LoginForm
 * @package Authentication\Form
 */
class LoginForm extends FormBase
{
    /**
     * LoginForm constructor.
     */
    public function __construct()
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'login');
        $this->setAttribute('class', 'form');
        $this->setAttribute('role', 'form');

        $this->setFormElements();
    }

    private function setFormElements()
    {
        $this->add([
            'name' => 'identity',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => [
                'class' => 'form-control input-lg',
                'id' => 'identity',
                'placeholder' => 'Username'
            ]
        ]);

        $this->add([
            'name' => 'credential',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => [
                'class' => 'form-control input-lg',
                'id' => 'credential',
                'placeholder' => 'Password'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Login',
                'id' => 'submit',
                'class' => 'btn btn-primary btn-block btn-lg'
            ],
        ]);
    }
}
