<?php

namespace Authentication\Form\Filter;

use Zend\InputFilter\InputFilter;

/**
 * Class GuestLoginInputFilter
 * @package Authentication\Form\Filter
 */
class GuestLoginInputFilter extends InputFilter
{
    /**
     * GuestLoginInputFilter constructor.
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
    }
}
