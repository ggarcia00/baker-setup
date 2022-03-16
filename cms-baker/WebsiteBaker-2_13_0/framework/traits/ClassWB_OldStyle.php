<?php

//declare(strict_types = 1);
//declare(encoding = 'UTF-8');


trait ClassWB_OldStyleClassWB_OldStyle
{

    // Get POST data
    public function get_post($mField) {
        return $this->oReg->Request->getParam($mField);
    }

    // Get POST data and escape it
    public function get_post_escaped($field) {
        $result = $this->get_post($field);
        return (\is_null($result)) ? null : $this->add_slashes($result);
    }

    // Get GET data
    public function get_get($field) {
        return $this->oReg->Request->getParam($field);
    }

}