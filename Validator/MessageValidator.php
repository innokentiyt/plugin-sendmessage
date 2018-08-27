<?php

namespace Kanboard\Plugin\Sendmessage\Validator;

use Kanboard\Validator\BaseValidator;
use SimpleValidator\Validator;
use SimpleValidator\Validators;

class MessageValidator extends BaseValidator
{
    public function validateMessage(array $values)
    {
        $v = new Validator($values, array(
            new Validators\Required('message', t('This field is required')), new Validators\Required('user_id', t('This field is required'))
        ));

        return array(
            $v->execute(),
            $v->getErrors(),
        );
    }
}
