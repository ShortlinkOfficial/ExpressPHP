<?php

namespace fr\dieunelson\webservices\hello;

use Exception;
use fr\dieunelson\webservices\Request;
use fr\dieunelson\webservices\RequestValidator;

class HelloValidator extends RequestValidator{

    public function __construct(){}

    public function validate(Request $req) {
      if (!array_key_exists("variable", $req->getParams())
          || strnatcmp($req->getParam("variable"), "disabled")!==0)
      {
        return true;
      } else if (strnatcmp($req->getParam("variable"), "disabled")==0) {
        $this->setException(new Exception("Unauthorized", 401));
      }
      return false;
    }

}