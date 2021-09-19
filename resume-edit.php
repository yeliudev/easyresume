<?php
include 'php/session.php';

header('content-type:text/html; charset=utf8');

include 'php/mysql.php';

if (!hasUser($conn, $_SESSION['username'])) {
    echo "<script>alert('Please sign in first!'); window.location.href = 'index.html';</script>";
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

$awards = $awards ? json_decode($awards, true) : false;
$jobs = $jobs ? json_decode($jobs, true) : false;

$birthdate = strtotime($birthdate) ? date('Y-m-d', strtotime($birthdate)) : '';
?>

<!-- Written by Ye Liu -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Resume - <?php echo $name ? $name : $_SESSION['username']; ?></title>
    <link rel="shortcut icon" href="static/assets/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="static/css/background.css">
    <link rel="stylesheet" href="static/css/bulma.min.css">
    <link rel="stylesheet" href="static/css/resume.css">
    <link rel="stylesheet" href="static/css/chart.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.transit@0.9.12/jquery.transit.min.js"></script>
    <script src="static/lib/verification.js"></script>
</head>

<body>
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">Please refine your resume</h1>
                <h3 class="subtitle is-7">Last updated: <?php echo $last_updated ? $last_updated : 'None'; ?></h3>
            </div>
        </div>
    </section>

    <section class="container">
        <form id="resume" class="resume">
            <div class="columns is-rtl">
                <div class="column is-3 is-align-center is-ltr">
                    <img id="avatar" class="avatar" <?php
                        if ($avatar) {
                            echo 'src="static/assets/transparent.png"';
                            echo 'style="background-image: url(' . $avatar . ');"';
                        } else {
                            echo 'src="static/assets/' . (!$gender || $gender == 'male' ? 'male.png"' : 'female.png"');
                        } ?>>
                    <div class="file">
                        <label class="file-label is-align-center">
                            <input id="avatar-input" class="file-input" type="file" name="avatar" accept="image/*" onchange="displayAvatar()">
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fa fa-upload"></i>
                                </span>
                                <span class="file-label">Select Photo</span>
                            </span>
                        </label>
                    </div>
                    <p id="avatar-warning" class="help is-danger">Photo size exceeds limit (2MB)</p>
                </div>

                <div class="column is-4 is-edit is-middle is-ltr">
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
                            <input class="input is-static is-grey" type="text" name="username" value="<?php echo $_SESSION['username']; ?>" readonly>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-three-fifths">
                            <label class="label">Name</label>
                            <div class="control has-icons-left">
                                <input id="name" class="input" type="text" name="name" data-valid="15 isNotEmpty isName" value="<?php echo $name; ?>" onblur="onVarify(this)">
                                <span class="icon is-small is-left">
                                    <i class="fa fa-user"></i>
                                </span>
                                <p id="name-warning" class="help is-danger">Invalid name</p>
                            </div>
                        </div>
                        <div class="column is-two-fifth">
                            <label class="label">Gender</label>
                            <div class="control is-radio">
                                <label class="radio"><input class="radio-icon" type="radio" name="gender" value="male" onclick="onSexClick(this.value)" <?php if ($gender == 'male') {echo 'checked';} ?>>Male</label>
                                <label class="radio"><input class="radio-icon" type="radio" name="gender" value="female" onclick="onSexClick(this.value)" <?php if ($gender == 'female') {echo 'checked';} ?>>Female</label>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-three-fifths">
                            <label class="label">Date of Birth</label>
                            <div class="control has-icons-left">
                                <input type="date" class="input" type="text" name="birthdate" value="<?php echo $birthdate; ?>" onblur="onVarify(this)">
                                <span class="icon is-small is-left">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="column is-two-fifth">
                            <label class="label">Hometown</label>
                            <div class="control has-icons-left">
                                <input id="hometown" class="input" type="text" name="hometown" data-valid="10 isNotEmpty isNormalStr" value="<?php echo $hometown; ?>" onblur="onVarify(this)">
                                <span class="icon is-small is-left">
                                    <i class="fa fa-address-book-o"></i>
                                </span>
                                <p id="hometown-warning" class="help is-danger">Invalid hometown</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="columns">
                <div class="column is-half">
                    <label class="label">Cellphone</label>
                    <div class="control has-icons-left">
                        <input id="cellphone" class="input" type="tel" name="cellphone" data-valid="11 isNotEmpty isNum" value="<?php echo $cellphone; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-phone"></i>
                        </span>
                        <p id="cellphone-warning" class="help is-danger">Invalid cellphone number (11 digits)</p>
                    </div>
                </div>

                <div class="column is-half">
                    <label class="label">Email</label>
                    <div class="control has-icons-left">
                        <input id="email" class="input" type="email" name="email" data-valid="30 isNotEmpty isEmail" value="<?php echo $email; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <p id="email-warning" class="help is-danger">Invalid email address</p>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-half">
                    <label class="label">Residence</label>
                    <div class="control has-icons-left">
                        <input id="residence" class="input" type="text" name="residence" data-valid="50 isNotEmpty isNormalStr" value="<?php echo $residence; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-address-card-o"></i>
                        </span>
                        <p id="residence-warning" class="help is-danger">Invalid residence</p>
                    </div>
                </div>

                <div class="column is-half">
                    <label class="label">Address</label>
                    <div class="control has-icons-left">
                        <input id="address" class="input" type="text" name="address" data-valid="50 isNotEmpty isNormalStr" value="<?php echo $address; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-home"></i>
                        </span>
                        <p id="address-warning" class="help is-danger">Invalid address</p>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2">
                    <label class="label">Degree</label>
                    <div class="select">
                        <select name="degree" onchange="onVarify(this, false, true)">
                            <option value="0" <?php if ($degree == '0') {echo 'selected';} ?>>Select</option>
                            <option value="1" <?php if ($degree == '1') {echo 'selected';} ?>>High School</option>
                            <option value="2" <?php if ($degree == '2') {echo 'selected';} ?>>College</option>
                            <option value="3" <?php if ($degree == '3') {echo 'selected';} ?>>Bachelor</option>
                            <option value="4" <?php if ($degree == '4') {echo 'selected';} ?>>Master</option>
                            <option value="5" <?php if ($degree == '5') {echo 'selected';} ?>>Doctor</option>
                        </select>
                    </div>
                    <p id="degree-warning" class="help is-danger">Please select your degree</p>
                </div>

                <div class="column is-4">
                    <label class="label">Institution</label>
                    <div class="control has-icons-left">
                        <input id="institution" class="input" type="text" name="institution" data-valid="20 isNotEmpty isNormalStr" value="<?php echo $institution; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-university"></i>
                        </span>
                        <p id="institution-warning" class="help is-danger">Invalid institution</p>
                    </div>
                </div>

                <div class="column is-4">
                    <label class="label">Major</label>
                    <div class="control has-icons-left">
                        <input id="major" class="input" type="text" name="major" data-valid="20 isNotEmpty isNormalStr" value="<?php echo $major; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-mortar-board"></i>
                        </span>
                        <p id="major-warning" class="help is-danger">Invalid major name</p>
                    </div>
                </div>

                <div class="column is-2">
                    <label class="label">Awards</label>
                    <a id="add-award-btn" class="button is-primary" onclick="onAddAwardClick()">Add</a>
                </div>
            </div>

            <?php if (!empty($awards)) {
                include 'php/awards-edit.php';
                appendAwards($awards);
            } ?>

            <div id="after-award-table" class="columns">
                <div class="column is-2">
                    <label class="label">Work Experience</label>
                    <div class="select">
                        <select name="working-years" onchange="onVarify(this, false, true)">
                            <option value="0" <?php if ($working_years == '0') {echo 'selected';} ?>>Select</option>
                            <option value="1" <?php if ($working_years == '1') {echo 'selected';} ?>>< 1 year</option>
                            <option value="2" <?php if ($working_years == '2') {echo 'selected';} ?>>1 ~ 3 years</option>
                            <option value="3" <?php if ($working_years == '3') {echo 'selected';} ?>>3 ~ 5 years</option>
                            <option value="4" <?php if ($working_years == '4') {echo 'selected';} ?>>5 ~ 10 years</option>
                            <option value="5" <?php if ($working_years == '5') {echo 'selected';} ?>>> 10 years</option>
                        </select>
                    </div>
                    <p id="working-years-warning" class="help is-danger">Please select the years of working</p>
                </div>

                <div class="column is-4">
                    <label class="label">Job Status</label>
                    <div class="control has-icons-left">
                        <input id="job-status" class="input" type="text" name="job-status" data-valid="30 isNotEmpty isNormalStr" value="<?php echo $job_status; ?>" onblur="onVarify(this)">
                        <span class="icon is-small is-left">
                            <i class="fa fa-line-chart"></i>
                        </span>
                        <p id="job-status-warning" class="help is-danger">Invalid job status</p>
                    </div>
                </div>

                <div class="column is-4">
                    <label class="label">Expected Salary</label>
                    <div class="control">
                        <div class="field has-addons">
                            <p class="control">
                                <span class="select">
                                    <select name="salary-type">
                                        <option value="0" <?php if ($salary_type == '0') {echo 'selected';} ?>>Annual</option>
                                        <option value="1" <?php if ($salary_type == '1') {echo 'selected';} ?>>Monthly</option>
                                        <option value="2" <?php if ($salary_type == '2') {echo 'selected';} ?>>Weekly</option>
                                        <option value="3" <?php if ($salary_type == '3') {echo 'selected';} ?>>Daily</option>
                                    </select>
                                </span>
                            </p>
                            <p class="control"><input id="salary" class="input is-align-right" type="text" name="salary" data-valid="10 isNotEmpty isNum" value="<?php echo $salary; ?>" onblur="onVarify(this)"></p>
                            <p class="control"><a class="button is-static">Dollars</a></p>
                        </div>
                        <p id="salary-warning" class="help is-danger is-align-top">Invalid expected salary</p>
                    </div>
                </div>

                <div class="column is-2">
                    <label class="label">Companies</label>
                    <a id="add-job-btn" class="button is-primary" onclick="onAddJobClick()">Add</a>
                </div>
            </div>

            <?php if (!empty($jobs)) {
                include 'php/jobs-edit.php';
                appendJobs($jobs);
            } ?>

            <div id="after-job-table" class="line"></div>

            <div class="field">
                <label class="label">Computer Skills<label>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">C/C++</label>
                </div>
                <div class="column is-4">
                    <input id="cpp-slider" class="cpp" type="range" name="cpp-ability" min="1" max="100" value="<?php echo $cpp_ability; ?>" onchange="drawChart()">
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">Python<label>
                </div>
                <div class="column is-4">
                    <input id="py-slider" class="py" type="range" name="py-ability" min="1" max="100" value="<?php echo $py_ability; ?>" onchange="drawChart()">
                </div>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">JAVA</label>
                </div>
                <div class="column is-4">
                    <input id="java-slider" class="java" type="range" name="java-ability" min="1" max="100" value="<?php echo $java_ability; ?>" onchange="drawChart()">
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">C#<label>
                </div>
                <div class="column is-4">
                    <input id="cs-slider" class="cs" type="range" name="cs-ability" min="1" max="100" value="<?php echo $cs_ability; ?>" onchange="drawChart()">
                </div>
            </div>

            <div class="columns">
                <div class="column is-1 is-offset-1">
                    <label class="label is-align-right">Git</label>
                </div>
                <div class="column is-4">
                    <input id="git-slider" class="git" type="range" name="git-ability" min="1" max="100" value="<?php echo $git_ability; ?>" onchange="drawChart()">
                </div>

                <div class="column is-1">
                    <label class="label is-align-right">LaTaX<label>
                </div>
                <div class="column is-4">
                    <input id="latax-slider" class="latax" type="range" name="latax-ability" min="1" max="100" value="<?php echo $latax_ability; ?>" onchange="drawChart()">
                </div>
            </div>

            <div class="field">
                <label class="label">Personal Statement</label>
                <div class="control">
                    <textarea id="statement" class="textarea" name="statement" placeholder="Your additional remarks" data-valid="512 isNormalStr" onblur="onVarify(this)"><?php echo $statement; ?></textarea>
                    <p id="statement-warning" class="help is-danger">Invalid personal statement</p>
                </div>
            </div>

            <div class="field is-grouped is-gap">
                <div class="control">
                    <button type="submit" class="button is-link" onclick="onSubmit()">Submit</button>
                </div>

            <?php if ($name) {
                echo '<div class="control">';
                echo '<button class="button is-light" onclick="onCancelClick()">Cancel</button>';
                echo '</div>';
            } ?>

            </div>
        </form>
    </section>

    <article id="message-success" class="message is-success is-bottom-right">
        <div class="message-header">
            <p>Notice</p>
            <button class="delete" onclick="onCloseSuccess()"></button>
        </div>
        <div class="message-body">Saved successfully</div>
    </article>

    <article id="messgae-error" class="message is-danger is-bottom-right">
        <div class="message-header">
            <p>Notice</p>
            <button class="delete" onclick="onCloseError()"></button>
        </div>
        <div id="message-body" class="message-body"></div>
    </article>
</body>

<script src="static/lib/background.js"></script>
<script src="static/lib/resume.js"></script>
<script src="static/lib/template.js"></script>

</html>
