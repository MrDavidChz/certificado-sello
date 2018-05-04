# Librería para el manejo de Certificados CSD (.CER - .KEY) y Generar el Sello,Numero de Certificado para la emisión de Facturas CFDI

## Instalación

```
composer require mrdavidchz/certificado-sello:dev-master
```
## Uso
- Manejo de Archivos .cer
```
	use MrDavidChz\CertificadoSello;

	$cert = CertificadoSello::cer($cerFile);
	$cert->getNoCertificado();
	$cert->decode();
	$cert->save();
```
- Manejo de Archivos .key
```
    $key = CertificadoSello::key($keyFile, $password,'C:\OpenSSL\bin\openssl.exe');
    $key->decode();
    $key->save();
```
- Validar si los archivo CER y KEY son Pareja
En caso que haya algun error agregar la ruta del OpenSsl
```
   CertificadoSello::matchCerKey($cerFile.'.pem',$keyFile.'.pem','C:\OpenSSL\bin\openssl.exe');
```