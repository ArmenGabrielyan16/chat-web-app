<?php

namespace Authentication\Form;

use Main\Form\FormBase;

/**
 * Class GuestLoginForm
 * @package Authentication\Form
 */
class GuestLoginForm extends FormBase
{
    /**
     * GuestLoginForm constructor.
     */
    public function __construct()
    {
        parent::__construct('guest_login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'guest_login');
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
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Guest Login',
                'id' => 'submit',
                'class' => 'btn btn-primary btn-block btn-lg'
            ],
        ]);
    }
}
