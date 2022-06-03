<?php
define('DB_HOST', 'mysql');
define('DB_NAME', 'easyresume');
define('DB_USER', 'easyresume');
define('DB_PWD', 'easyresume');

define('SQL_CHECK', "SELECT 1 FROM user WHERE username=? LIMIT 1");
define('SQL_SELECT_USER', "SELECT salt,password,name FROM user WHERE username=? LIMIT 1");
define('SQL_SELECT_RESUME', "SELECT name,gender,avatar,birthdate,hometown,cellphone,email,residence,address,degree,institution,major,awards,working_years,job_status,salary_type,salary,jobs,cpp_ability,py_ability,java_ability,cs_ability,git_ability,latax_ability,statement,last_updated FROM user WHERE username=? LIMIT 1");
define('SQL_UPDATE_ALL', "UPDATE user SET name=?,gender=?,avatar=?,birthdate=FROM_UNIXTIME(?),hometown=?,cellphone=?,email=?,residence=?,address=?,degree=?,institution=?,major=?,awards=?,working_years=?,job_status=?,salary_type=?,salary=?,jobs=?,cpp_ability=?,py_ability=?,java_ability=?,cs_ability=?,git_ability=?,latax_ability=?,statement=?,last_updated=FROM_UNIXTIME(?) WHERE username=?");
define('SQL_UPDATE', "UPDATE user SET name=?,gender=?,birthdate=FROM_UNIXTIME(?),hometown=?,cellphone=?,email=?,residence=?,address=?,degree=?,institution=?,major=?,awards=?,working_years=?,job_status=?,salary_type=?,salary=?,jobs=?,cpp_ability=?,py_ability=?,java_ability=?,cs_ability=?,git_ability=?,latax_ability=?,statement=?,last_updated=FROM_UNIXTIME(?) WHERE username=?");
define('SQL_INSERT_USER', "INSERT user (username,salt,password) VALUES (?,?,?)");

function hasUser($conn, $username)
{
    $sql_stmt = $conn->prepare(SQL_CHECK);
    $sql_stmt->bind_param('s', $username);
    $sql_stmt->bind_result($hasUser);
    $sql_stmt->execute();
    $sql_stmt->fetch();
    $sql_stmt->close();

    return $hasUser;
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

if (mysqli_connect_errno()) {
    exit();
}
