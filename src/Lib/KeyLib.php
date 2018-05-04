<?php

namespace Kinedu\CfdiCertificate\Lib;

class KeyLib
{
    /**
     * File to decode.
     *
     * @var string
     */
    protected $file;

    protected $openSsl;
    /**
     * Password to decode the file.
     *
     * @var string
     */
    protected $password;

    
    /**
     * Create a new key strategy instance.
     *
     * @param $file
     * @param string $password
     */
    public function __construct($file, $password,$openSsl)
    {
        $this->fileNameDir = $file;
        $this->password    = $password;
        $this->openSsl     = $openSsl;

    }

    /**
     * @return string
     */
    public function decode() 
    {
        $pem = shell_exec("{$this->openSsl} pkcs8 -inform DER -in {$this->fileNameDir} -passin pass:{$this->password}");

        if(!empty($pem)){
            return $pem;
        }

        return 'Verifique que el Password pertenezca al archivo .Key O especifique la ruta openSSL';

    }



    /**
     * @param string $directory
     * @param string $filename
     *
     * @return integer|bool
     */
    public function save($directory=null)
    {
        if (is_null($directory)) {
            return file_put_contents($this->fileNameDir.'.pem', $this->decode());
        } else {
            $directory = rtrim($directory, '/').'/';
            $file = new SplFileInfo($this->fileNameDir);
            return file_put_contents($directory.$file->getFilename().'.pem', $this->decode());
        }
    }    

}
