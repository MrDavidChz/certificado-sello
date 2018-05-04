<?php

namespace MrDavidChz\Sat\Lib;
use SplFileInfo;
class CerLib
{
    /**
     * File to decode.
     *
     * @var string
     */
    protected $fileContents;
    protected $fileNameDir;


    /**
     * Create a new cer strategy instance.
     *
     * @param $file
     */
    public function __construct($fileCer)
    {
        $this->fileContents = file_get_contents($fileCer);
        $this->fileNameDir  = $fileCer;
    }

    /**
     * Convert .cer to .pem
     *
     * @return string
     */
    public function decode()
    {
        return '-----BEGIN CERTIFICATE-----'.PHP_EOL
        .chunk_split(base64_encode($this->fileContents), 64, PHP_EOL)
        .'-----END CERTIFICATE-----'.PHP_EOL;
    }

    /**
     * @return string
     */
    public function getNoCertificado()
    {

        $data = $this->parseCertificate();
        $data = str_split($data['serialNumberHex'], 2);

        $serialNumber = null;

        for ($i = 0; $i < sizeof($data); $i++) {
            $serialNumber .= substr($data[$i], 1);
        }

        return $serialNumber;
    }

    /**
     * @return string
     */
    public function getExpirationDate()
    {
        $data = $this->parseCertificate();

        return $this->dateFormat($data['validTo_time_t']);
    }

    /**
     * @return string
     */
    public function getInitialDate()
    {
        $data = $this->parseCertificate();

        return $this->dateFormat($data['validFrom_time_t']);
    }

    /**
     * @return array
     */
    protected function parseCertificate()
    {
        return openssl_x509_parse($this->decode());
    }

    /**
     * @param string $date
     */
    protected function dateFormat(string $date)
    {
        return date('Y-m-d H:i:s', $date);
    }

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
