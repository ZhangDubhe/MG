<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/15
 * Time: 17:09
 */
class user
{
    var $u_name;
    var $pwd;
    var $age;
    function output() {
        echo $this->age;
    }
    function setAge($age) {
        $this->age = $age;
    }
}
class event{}
