<?php

namespace src\application\core;

class Server extends SuperGlobalVariables
{
    protected function setValues($server = null)
    {
        if ($server !== null) {
            foreach ($server as $key => $value) {
                $this->values[$key] = $value;
            }
        } else {
            foreach ($_SERVER as $key => $value) {
                $this->values[$key] = $value;
            }
        }
    }
}
