<?php

require_once 'Services/Keenio.php';

$oKeenIo = new Keenio();
$oKeenIo->doPost($push_array);


/* In Services/Keenio.php update:

	private $_keyWrite = '';
    private $_keyRead = '';
    private $_projectId = '';
    private $_endPoint = '';
    private $_lastResponseStatus = '';
    private $_responseErrMsg = '';
    
    (Working on calling this externally)
    
*/

?>