<?php

namespace MrDavidChz\Sat;

use MrDavidChz\Sat\Lib\CerLib;
use MrDavidChz\Sat\Lib\KeyLib;
use Exception;
use SplFileInfo;
class CertificadoSello
{

    /**
     * Create a new certificate instance.
     *
     * @param string $fileKey
     * @param string $passwordKey
     * @param string $openSsl
    */
    static function key($fileKey, $passwordKey,$openSsl='openssl'){

        $ext = new SplFileInfo($fileKey);

        if ($ext->getExtension()=='key') {
             return new KeyLib($fileKey,$passwordKey,$openSsl);
        } 

        return false;
    }

    static function cer($fileCer){
        $ext = new SplFileInfo($fileCer);

        if ($ext->getExtension()=='cer') {
             return new CerLib($fileCer);
        } 

        return false;
    }



    /**
     * Valida que el archivo >CER y KEY sean pareja.
     * 
     * @return bool TRUE: cuando el cer y el key son pareja, en caso contrario false
     */
    static function matchCerKey($cer, $key,$openSsl='openssl'){
       
       $salidaCer = shell_exec("$openSsl x509 -noout -modulus -in $cer 2>&1");

       $salidaKey = shell_exec("$openSsl rsa -noout -modulus -in $key 2>&1");

            if ($salidaCer == $salidaKey) {
                return true;
            } else {
                return false;
            }
        
    }
}
