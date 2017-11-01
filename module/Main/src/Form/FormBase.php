<?php

namespace Main\Form;

use Zend\Form\Form;

/**
 * Class FormBase
 * @package Main\Form
 */
class FormBase extends Form
{
    /**
     * FormBase constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => $name . '_csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ]
            ]
        ]);
    }
}
