<?php

namespace Chat\Form;

use Main\Form\FormBase;

/**
 * Class ChatForm
 * @package Chat\Form
 */
class ChatForm extends FormBase
{
    /**
     * ChatForm constructor.
     */
    public function __construct()
    {
        parent::__construct('chat');

        $this->setAttribute('id', 'add_chat_room');
        $this->setAttribute('class', 'form');
        $this->setAttribute('method', 'post');

        $this->setFormElements();
    }

    private function setFormElements()
    {
        $this->add([
            'name' => 'message_content',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => [
                'id' => 'message_content',
                'class' => 'form-control',
            ],
            'options' => [
                'required' => true
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => [
                'type' => 'submit',
                'id' => 'send',
                'class' => 'btn btn btn-primary',
            ],
            'options' => [
                'label' => 'Send',
            ],
        ]);
    }
}
