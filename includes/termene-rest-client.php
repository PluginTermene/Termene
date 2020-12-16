<?php
class Termene_REST_Client {
    const CIF_URL = 'https://termene.ro/api/dateFirmaSumar.php?cui=%s';
    public static $counter = 0;
    private $hash   = '';

    function __construct($user, $password, $wpInfo = []) {
        $this->hash = base64_encode($user.':'.$password);
    }


    public function getHash()
    {
        return $this->hash;
    }
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    private function _callServer($url, $data='', $request='', $headAccept="Accept: application/json") {
        if (empty($url))   return FALSE;

        $ch     = $this->_cURL($url, $data, $request, $headAccept);
       
        $return = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($status!=200) {
            $errorMessage = json_decode($return, true);
            throw new \Exception($errorMessage );
            $return = '';
        } else{
            $return = json_decode($return, true);
        }

        return $return;
    }

    private function _cURL($url, $data, $request, $headAccept) {

        self::$counter++;
        // every 5 requests wait a second
        if (self::$counter % 5 === 0) {
            sleep(1);
        }
        $headers = array($headAccept, "Authorization: Basic " . $this->hash);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if ( !empty($data) ) {
            $headers[] = "Content-Type: application/json; charset=utf-8";
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        if ( !empty($request)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return $ch;
    }
    
    public function getDataByCUI($companyCuiCode) {
        $url = sprintf(self::CIF_URL, $companyCuiCode);
        return $this->_callServer($url);

    }
}