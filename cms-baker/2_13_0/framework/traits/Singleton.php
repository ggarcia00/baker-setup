<?php

namespace traits;

trait Singleton
{
   private static $oInstance = null;

/**
 * get a valid instance of this class
 * @return object
 */
    public static function getInstance()
    {

      if (self::$oInstance === null) {
          self::$oInstance = new static;
      }
      return self::$oInstance;
    } // function

} // trait
