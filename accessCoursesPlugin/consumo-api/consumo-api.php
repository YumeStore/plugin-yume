<?php
require_once('end-points.php');

class ConsumoApi
{
    var $url;
    var $token;

    function __construct($url, $token)
    {
        $this->url = $url;
        $this->token = $token;
    }

    public function retornoListaCursos($nameFilter = "")
    {
        $ch = curl_init("{$this->url}" . EndPoints::GetListaCursos ."?page=1&token={$this->token}&query={$nameFilter}");

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => true
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    public function retornoIframeCurso($user_id, $curso_id){
        $ch = curl_init("{$this->url}" . EndPoints::GetEnvironment ."?token={$this->token}&user_id={$user_id}&course_id={$curso_id}&course_layout=2&course_activities=1");

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => true
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
