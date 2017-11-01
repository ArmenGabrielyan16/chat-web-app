<?php

namespace Authentication\Form\Filter;

use Zend\InputFilter\InputFilter;

/**
 * Class LoginInputFilter
 * @package Authentication\Form\Filter
 */
class LoginInputFilter extends InputFilter
{
    /**
     * LoginFilter constructor.
     */
    public function __construct()
    {
        $this->setInputFilters();
    }

    private function setInputFilters()
    {
        $this->add(
            array(
                'name' => 'identity',
                'required' => true,
                'validators' => [],
                'filters' => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags'],
                ],
            )
        );

        $this->add([
            'name' => 'credential',
            'required' => true,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 6,
                    ],
                ],
            ],
        ]);
    }
}
