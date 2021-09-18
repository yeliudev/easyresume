<?php
include 'php/session.php';

header('content-type:text/html; charset=utf8');

include 'php/mysql.php';

if (!hasUser($conn, $_SESSION['username'])) {
    echo "<script>alert('Please sign in first!');window.location.href='index.html';</script>";
    $conn->close();
    exit();
}

$sql_stmt = $conn->prepare(SQL_SELECT_RESUME);
$sql_stmt->bind_param('s', $_SESSION['username']);
$sql_stmt->bind_result($name, $gender, $avatar, $birthdate, $hometown, $cellphone, $email, $residence, $address, $degree, $institution, $major, $awards, $working_years, $job_status, $salary_type, $salary, $jobs, $cpp_ability, $py_ability, $java_ability, $cs_ability, $git_ability, $latax_ability, $statement, $last_updated);
$sql_stmt->execute();
$sql_stmt->fetch();
$sql_stmt->close();

$conn->close();

if (!$name) {
    echo "<script>alert('Please refine the resume first!');window.location.href='resume-edit.php';</script>";
    exit();
}

$awards = $awards ? json_decode($awards, true) : false;
$jobs = $jobs ? json_decode($jobs, true) : false;

$birthdate = date('Y-m-d', strtotime($birthdate));
?>

<!-- Written by Ye Liu -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview Resume - <?php echo $name; ?></title>
    <link rel="shortcut icon" href="static/assets/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="static/css/background.css">
    <link rel="stylesheet" href="static/css/bulma.min.css">
    <link rel="stylesheet" href="static/css/resume.css">
    <link rel="stylesheet" href="static/css/chart.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.transit@0.9.12/jquery.transit.min.js"></script>
</head>

<body>
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <h1 class="title"><?php echo $name; ?>'s Resume</h1>
                <h3 class="subtitle is-7">Last updated: <?php echo $last_updated; ?></h3>
            </div>
        </div>
    </section>

    <section class="container">
        <form class="resume">
            <div class="columns is-rtl">
                <div class="column is-3 is-middle is-ltr">
                    <img id="avatar" class="avatar" <?php
                        if ($avatar) {
                            echo 'src="static/assets/transparent.png"';
                            echo 'style="background-image: url(' . $avatar . ');"';
                        } else {
                            echo 'src="static/assets/' . ($gender == 'male' ? 'male.png"' : 'female.png"');
                        } ?>>
                </div>

                <div class="column is-4 is-preview is-middle is-ltr">
                    <canvas id="chart" height="110px">This browser does not support HTML5 Canvas.</canvas>
                    <div class="flex-container">
                        <div class="chart-label">
                            <div class="label-icon cpp"></div>
                            <label class="label-text">C/C++</label>
                        </div>
                        <div class="chart-label">
                            <div class="label-icon py"></div>
                            <label class="label-text">Python</label>
                        </div>
                        <div class="chart-label">
                            <div class="label-icon java"></div>
                            <label class="label-text">JAVA</label>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="chart-label">
                            <div class="label-icon cs"></div>
                            <label class="label-text">C#</label>
                        </div>
                        <div class="chart-label">
                            <div class="label-icon git"></div>
                            <label class="label-text">Git</label>
                        </div>
                        <div class="chart-label">
                            <div class="label-icon latax"></div>
                            <label class="label-text">LaTaX</label>
                        </div>
                    </div>
                </div>

                <div class="column is-5 is-ltr">
                    <div class="field">
                        <label class="label">Username</label>
                        <div class="control has-indent">
                            <input class="input is-static is-grey" type="text" value="<?php echo $_SESSION['username']; ?>" readonly>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-three-fifths">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input is-static" type="text" value="<?php echo $name; ?>" readonly>
                            </div>
                        </div>
                        <div class="column is-two-fifth">
                            <label class="label">Gender</label>
                            <div class="control">
                                <input class="input is-static" type="text" value="<?php echo $gender == 'male' ? 'Male' : 'Female'; ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-three-fifths">
                            <label class="label">Date of Birth</label>
                            <div class="control">
                                <input class="input is-static" type="date" value="<?php echo $birthdate; ?>" readonly>
                            </div>
                        </div>
                        <div class="column is-two-fifth">
                            <label class="label">Hometown</label>
                            <div class="control">
                                <input class="input is-static" type="text" value="<?php echo $hometown; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="columns">
                <div class="column is-half">
                    <label class="label">Cellphone</label>
                    <div class="control">
                        <input class="input is-static" type="tel" value="<?php echo $cellphone; ?>" readonly>
                    </div>
                </div>

                <div class="column is-half">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input is-static" type="email" value="<?php echo $email; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-half">
                    <label class="label">Residence</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $residence; ?>" readonly>
                    </div>
                </div>

                <div class="column is-half">
                    <label class="label">Address</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $address; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="columns">
                <div class="column is-2">
                    <label class="label">Degree</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php
                            switch ($degree) {
                                case 1:
                                    echo 'High School';
                                    break;
                                case 2:
                                    echo 'College';
                                    break;
                                case 3:
                                    echo 'Bachelor';
                                    break;
                                case 4:
                                    echo 'Master';
                                    break;
                                case 5:
                                    echo 'Doctor';
                                    break;
                                default:
                                    echo 'Unknown';
                            } ?>" readonly>
                    </div>
                </div>

                <div class="column is-5">
                    <label class="label">Institution</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $institution; ?>" readonly>
                    </div>
                </div>

                <div class="column is-5">
                    <label class="label">Major</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $major; ?>" readonly>
                    </div>
                </div>
            </div>

            <?php if (!empty($awards)) {
                include 'php/awards-preview.php';
                appendAwards($awards);
            } ?>

            <div class="columns">
                <div class="column is-2">
                    <label class="label">Work Experience</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php
                            switch ($working_years) {
                                case 1:
                                    echo '< 1 year';
                                    break;
                                case 2:
                                    echo '1 ~ 3 years';
                                    break;
                                case 3:
                                    echo '3 ~ 5 years';
                                    break;
                                case 4:
                                    echo '5 ~ 10 years';
                                    break;
                                case 5:
                                    echo '> 10 years';
                                    break;
                                default:
                                    echo 'Unknown';
                            } ?>" readonly>
                    </div>
                </div>

                <div class="column is-5">
                    <label class="label">Job Status</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php echo $job_status; ?>" readonly>
                    </div>
                </div>

                <div class="column is-5">
                    <label class="label">Expected Salary</label>
                    <div class="control">
                        <input class="input is-static" type="text" value="<?php
                            switch ($salary_type) {
                                case 0:
                                    echo 'Annual ';
                                    break;
                                case 1:
                                    echo 'Monthly ';
                                    break;
                                case 2:
                                    echo 'Weekly ';
                                    break;
                                case 3:
                                    echo 'Daily ';
                                    break;
                                default:
                                    echo 'Unknown';
                                    return;
                            }
                            echo $salary;
                            echo ' Dollars'; ?>" readonly>
                    </div>
                </div>
            </div>

            <?php if (!empty($jobs)) {
                include 'php/jobs-preview.php';
                appendJobs($jobs);
            } ?>

            <div class="line"></div>

            <div class="field">
                <label class="label">Computer Skills<label>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">C/C++</label>
                </div>
                <div class="column is-4">
                    <progress id="cpp-slider" class="progress is-cpp" max="100" value="<?php echo $cpp_ability; ?>"></progress>
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">Python<label>
                </div>
                <div class="column is-4">
                    <progress id="py-slider" class="progress is-py" max="100" value="<?php echo $py_ability; ?>"></progress>
                </div>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">JAVA</label>
                </div>
                <div class="column is-4">
                    <progress id="java-slider" class="progress is-java" max="100" value="<?php echo $java_ability; ?>"></progress>
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">C#<label>
                </div>
                <div class="column is-4">
                    <progress id="cs-slider" class="progress is-cs" max="100" value="<?php echo $cs_ability; ?>"></progress>
                </div>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">Git</label>
                </div>
                <div class="column is-4">
                    <progress id="git-slider" class="progress is-git" max="100" value="<?php echo $git_ability; ?>"></progress>
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">LaTaX<label>
                </div>
                <div class="column is-4">
                    <progress id="latax-slider" class="progress is-latax" max="100" value="<?php echo $latax_ability; ?>"></progress>
                </div>
            </div>

            <div class="field">
                <label class="label">Personal Statement</label>
                <div class="control">
                    <textarea id="statement-preview" class="input is-static is-dark-grey" readonly><?php echo $statement ? $statement : '无'; ?></textarea>
                </div>
            </div>

            <div class="field is-grouped is-gap">
                <div class="control">
                    <button class="button is-primary" onclick="onEditClick()">Edit</button>
                </div>
                <div class="control">
                    <button class="button is-light" onclick="onLogoutClick()">Exit</button>
                </div>
            </div>
        </form>
    </section>
</body>

<script src="static/lib/background.js"></script>
<script src="static/lib/resume.js"></script>
<script src="static/lib/template.js"></script>

</html>
