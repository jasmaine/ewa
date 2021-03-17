<?php
    
$data = new Mysql();

if ($user1 = $data->limit(4)->get('user', 'name')) {
    echo '<pre>';

    var_dump($user1);
} else {
    echo 'No Data';
}
