<?php

namespace src\application\core;

class Post extends SuperGlobalVariables
{
    protected function setValues($post = null)
    {
        if ($post !== null) {
            foreach ($post as $key => $value) {
                $this->values[$key] = $value;
            }
        } else {
            foreach ($_POST as $key => $value) {
                $this->values[$key] = $value;
            }
        }
    }
}
