<?php
function appendAwards($awards)
{
    $levelMap = array('0' => '校级', '1' => '市级', '2' => '省级', '3' => '国家级', '4' => '世界级');

    echo '<div class="field">';
    echo '<label class="label">获奖经历</label>';
    echo '<div class="control">';
    echo '<div class="columns">';
    echo '<div class="column is-10 is-offset-1">';

    echo '<table class="table is-fat">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>年份</th>';
    echo '<th>奖项级别</th>';
    echo '<th>奖项名称</th>';
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
