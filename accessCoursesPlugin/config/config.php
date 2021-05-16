<?php
$url_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
define('pg', 'http://'.$url_host . '/eduAcademy');