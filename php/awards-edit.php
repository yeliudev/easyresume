<?php
function appendAwards($awards)
{
    echo '<div id="award-table-container" class="columns">';
    echo '<div id="award-table" class="column is-10 is-offset-1 is-table">';
    foreach ($awards as $item) {
        echo '<div class="columns">';
        echo '<div class="column is-2">';
        echo '<div class="control">';
        echo '<input class="input" type="text" name="award-time" placeholder="年份" data-valid="4 isNotEmpty isNum" value="' . $item['time'] . '" onblur="onVarify(this)">';
        echo '<p name="award-time-warning" class="help is-danger">不是有效的年份</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="column is-2">';
        echo '<div class="select">';
        echo '<select name="award-level">';
        echo $item['level'] == '0' ? '<option value="0" selected>校级</option>' : '<option value="0">校级</option>';
        echo $item['level'] == '1' ? '<option value="1" selected>市级</option>' : '<option value="1">市级</option>';
        echo $item['level'] == '2' ? '<option value="2" selected>省级</option>' : '<option value="2">省级</option>';
        echo $item['level'] == '3' ? '<option value="3" selected>国家级</option>' : '<option value="3">国家级</option>';
        echo $item['level'] == '4' ? '<option value="4" selected>世界级</option>' : '<option value="4">世界级</option>';
        echo '</select>';
        echo '</div>';
        echo '</div>';

        echo '<div class="column is-7">';
        echo '<div class="control has-icons-left">';
        echo '<input class="input" type="text" name="award-title" placeholder="奖项名称" data-valid="50 isNotEmpty isNormalStr" value="' . $item['title'] . '" onblur="onVarify(this)">';
        echo '<span class="icon is-small is-left">';
        echo '<i class="fa fa-trophy"></i>';
        echo '</span>';
        echo '<p name="award-title-warning" class="help is-danger">不是有效的奖项名称</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="column is-1 is-middle">';
        echo '<a class="delete" onclick="onDelAwardClick(this)"></a>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}
