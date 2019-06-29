<?php 

namespace Core\Validators;
use Core\Validators\CustomValidator;

class MaximumValidator extends CustomValidator{

    public function runValidation()
    {
        $value = $this->_model->{$this->field};
        $pass = (strlen($value) <= $this->rule);
        return $pass;
    }

}
