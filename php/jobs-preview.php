<?php
function appendJobs($jobs)
{
    echo '<div class="field">';
    echo '<label class="label">Work Experience</label>';
    echo '<div class="control">';
    echo '<div class="columns">';
    echo '<div class="column is-10 is-offset-1">';

    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Period</th>';
    echo '<th>Company Name</th>';
    echo '<th>Position</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($jobs as $item) {
        echo '<tr>';
        echo '<td>' . $item['from'] . ' ~ ' . $item['to'] . '</td>';
        echo '<td>' . $item['company'] . '</td>';
        echo '<td>' . $item['title'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
