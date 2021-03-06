<?php

namespace src\application\core;

class Get extends SuperGlobalVariables
{
    protected function setValues($get = null)
    {
        if ($get !== null) {
            foreach ($get as $key => $value) {
                $this->values[$key] = $value;
            }
        } else {
            foreach ($_GET as $key => $value) {
                $this->values[$key] = $value;
            }
        }
    }
}
