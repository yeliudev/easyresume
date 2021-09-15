<?php
$regListUser = array(
    'username' => '/^[\w.@]{1,20}$/u',
    'password' => '/^[\w]{32}$/u');
$regListResume = array(
    'name' => '/^[A-Za-z\x{4e00}-\x{9fa5}.\(\) ·]{1,15}$/u',
    'birthdate' => '/^[0-9\-]{10}$/u',
    'hometown' => '/^[a-zA-Z0-9\x{4e00}-\x{9fa5}\-\(\) ,.]{1,10}$/u',
    'cellphone' => '/^[0-9]{11}$/u',
    'email' => '/^[\w]+@[A-Za-z0-9]+.[A-Za-z0-9.]{1,30}$/u',
    'residence' => '/^[a-zA-Z0-9\x{0391}-\x{FFE5}\-\(\)\[\] ,.]{1,50}$/u',
    'address' => '/^[a-zA-Z0-9\x{0391}-\x{FFE5}\-\(\)\[\] ,.]{1,50}$/u',
    'degree' => '/^[1-5]{1}$/u',
    'institution' => '/^[a-zA-Z0-9\x{0391}-\x{FFE5}\'"\-\(\) ,.]{1,20}$/u',
    'major' => '/^[a-zA-Z0-9\x{0391}-\x{FFE5}\'"\+\-\(\) ,]{1,20}$/u',
    'awards' => '/^[A-Za-z0-9\x{0391}-\x{FFE5}\'":,.\(\)\[\]\{\} ·]{0,1024}$/u',
    'working-years' => '/^[1-5]{1}$/u',
    'job-status' => '/^[a-zA-Z0-9\x{0391}-\x{FFE5}\-\(\) ,.]{1,30}$/u',
    'salary-type' => '/^[0-3]{1}$/u',
    'salary' => '/^[0-9]{1,10}$/u',
    'jobs' => '/^[A-Za-z0-9\x{0391}-\x{FFE5}\'":,.\(\)\[\]\{\} ·]{0,1024}$/u',
    'cpp-ability' => '/^[0-9]{1,3}$/u',
    'py-ability' => '/^[0-9]{1,3}$/u',
    'java-ability' => '/^[0-9]{1,3}$/u',
    'cs-ability' => '/^[0-9]{1,3}$/u',
    'git-ability' => '/^[0-9]{1,3}$/u',
    'latax-ability' => '/^[0-9]{1,3}$/u',
    'statement' => '/^[\w\x{0391}-\x{FFE5}\'"\/\+:;\s\(\)\[\]\{\}\-,.]{0,500}$/u');

function verify($data, $regList)
{
    foreach ($regList as $reg) {
        if (!preg_match($reg, $data[array_keys($regList, $reg, true)[0]])) {
            return false;
        }
    }
    return true;
}
