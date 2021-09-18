<?php
function appendAwards($awards)
{
    $levelMap = array('0' => 'College', '1' => 'City', '2' => 'State', '3' => 'Nation', '4' => 'World');

    echo '<div class="field">';
    echo '<label class="label">Awards</label>';
    echo '<div class="control">';
    echo '<div class="columns">';
    echo '<div class="column is-10 is-offset-1">';

    echo '<table class="table is-fat">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Year</th>';
    echo '<th>Award Level</th>';
    echo '<th>Award Name</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($awards as $item) {
        echo '<tr>';
        echo '<td>' . $item['time'] . '</td>';
        echo '<td>' . $levelMap[$item['level']] . '</td>';
        echo '<td>' . $item['title'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="line"></div>';
}
