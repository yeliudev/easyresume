<?php
function appendJobs($jobs)
{
    echo '<div class="field">';
    echo '<label class="label">工作经历</label>';
    echo '<div class="control">';
    echo '<div class="columns">';
    echo '<div class="column is-10 is-offset-1">';

    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>起止年份</th>';
    echo '<th>公司名称</th>';
    echo '<th>职务</th>';
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
