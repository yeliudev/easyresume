<?php
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PWD', '');
define('DB_NAME', '');

define('SQL_CHECK', "SELECT 1 FROM user WHERE username=? LIMIT 1");
define('SQL_SELECT_USER', "SELECT salt,password,name FROM user WHERE username=? LIMIT 1");
define('SQL_SELECT_RESUME', "SELECT name,sex,avatarUrl,birthdate,birthplace,cellphone,email,residence,address,education,school,major,awards,work_time,job_status,salary_type,salary,jobs,cpp_ability,py_ability,java_ability,cs_ability,git_ability,latax_ability,remark,last_modify FROM user WHERE username=? LIMIT 1");
define('SQL_UPDATE_ALL', "UPDATE user SET name=?,sex=?,avatarUrl=?,birthdate=FROM_UNIXTIME(?),birthplace=?,cellphone=?,email=?,residence=?,address=?,education=?,school=?,major=?,awards=?,work_time=?,job_status=?,salary_type=?,salary=?,jobs=?,cpp_ability=?,py_ability=?,java_ability=?,cs_ability=?,git_ability=?,latax_ability=?,remark=?,last_modify=FROM_UNIXTIME(?) WHERE username=?");
define('SQL_UPDATE', "UPDATE user SET name=?,sex=?,birthdate=FROM_UNIXTIME(?),birthplace=?,cellphone=?,email=?,residence=?,address=?,education=?,school=?,major=?,awards=?,work_time=?,job_status=?,salary_type=?,salary=?,jobs=?,cpp_ability=?,py_ability=?,java_ability=?,cs_ability=?,git_ability=?,latax_ability=?,remark=?,last_modify=FROM_UNIXTIME(?) WHERE username=?");
define('SQL_INSERT', "INSERT user (username,salt,password) VALUES (?,?,?)");

// 连接数据库
$conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

// 检查连接是否成功
if (mysqli_connect_errno()) {
    exit();
}
