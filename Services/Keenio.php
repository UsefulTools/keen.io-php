<?php
class Keenio
{
    private $_keyWrite = '';
    private $_keyRead = '';
    private $_projectId = '';
    private $_endPoint = '';
    private $_lastResponseStatus = '';
    private $_responseErrMsg = '';
    public function __construct($keyWrite = null, $keyRead = null, $projectId = null)
    {
        if(isset($keyWrite)) {
            $this->_keyWrite = $keyWrite;
        }
        if(isset($keyRead)) {
            $this->_keyRead = $keyRead;
        }
        if(isset($projectId)) {
            $this->_projectId = $projectId;
        }
        $this->_endPoint = 'https://api.keen.io/3.0/projects/';
    }
    public function doPost(array $params, $events = 'complete_call', $uri = null)
    {
        $uri = $uri ? $uri : $this->_endPoint . $this->_projectId.'/events/'.$events.'?api_key='.$this->_keyWrite;
        $json_str = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
         
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        /*
         * for debug
        */
        /*
        try{
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('/tmp/keeio-log', 'a+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
        }catch (Exception $e){}
        */
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_str))
        );
        $response_str = curl_exec($ch);
        $response = json_decode($response_str);
        $this->_lastResponseStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $return = true;
        if($response->created !== true) {
            $return = false;
            $this->_responseErrMsg = $response_str;
        }
        return $return;
    }
    public function getLastResponseStatus()
    {
        return $this->_lastResponseStatus;
    }
    public function getResponseErrMsg()
    {
        return $this->_responseErrMsg;
    }
}