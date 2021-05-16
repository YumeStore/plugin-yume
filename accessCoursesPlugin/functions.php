<?php
require_once(dirname(__FILE__).'/consumo-api/consumo-api.php');

$consumoApi = new ConsumoApi('https://www.iped.com.br/','b6d5ee6c0bee8cb0e35a33e9677b45afc60d7eff');
$consumoApi->retornoListaCursos();
?>