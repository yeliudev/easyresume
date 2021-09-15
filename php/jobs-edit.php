<?php
function appendJobs($jobs)
{
    echo '<div id="job-table-container" class="columns">';
    echo '<div id="job-table" class="column is-10 is-offset-1 is-table">';
    foreach ($jobs as $item) {
        echo '<div class="columns">';
        echo '<div class="column is-3">';
        echo '<div class="control">';
        echo '<div class="field has-addons is-year">';
        echo '<p class="control">';
        echo '<input class="input" type="text" name="job-from-time" placeholder="Year" data-valid="4 isNotEmpty isNum" value="' . $item['from'] . '" onblur="onVarify(this, true)">';
        echo '</p>';
        echo '<p class="control">';
        echo '<a class="button is-static">to</a>';
        echo '</p>';
        echo '<p class="control">';
        echo '<input class="input" type="text" name="job-to-time" placeholder="Year" data-valid="4 isNotEmpty isNum" value="' . $item['to'] . '" onblur="onVarify(this, true)">';
        echo '</p>';
        echo '</div>';
        echo '<p name="job-time-warning" class="help is-danger is-align-top">Invalid job period</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="column is-5">';
        echo '<div class="control has-icons-left">';
        echo '<input class="input" type="text" name="job-company" placeholder="Company Name" data-valid="30 isNotEmpty isNormalStr" value="' . $item['company'] . '" onblur="onVarify(this)">';
        echo '<span class="icon is-small is-left">';
        echo '<i class="fa fa-building"></i>';
        echo '</span>';
        echo '<p name="job-company-warning" class="help is-danger">Invalid company name</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="column is-3">';
        echo '<div class="control has-icons-left">';
        echo '<input class="input" type="text" name="job-title" placeholder="Position" data-valid="20 isNotEmpty isNormalStr" value="' . $item['title'] . '" onblur="onVarify(this)">';
        echo '<span class="icon is-small is-left">';
        echo '<i class="fa fa-puzzle-piece"></i>';
        echo '</span>';
        echo '<p name="job-title-warning" class="help is-danger">Invalid position</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="column is-1 is-middle">';
        echo '<a class="delete" onclick="onDelJobClick(this)"></a>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}
