<?php

namespace Javiacei\WeatherGuyBundle\Remote;

/**
 * AemetRemote
 *
 * @package JaviaceiLyricsBundle
 * @subpackage Remote
 * @author Fco Javier Aceituno <fco.javier.aceituno@gmail.com>
 * @copyright Fco Javier Aceituno
 */
class AemetRemote
{
    const FTP_SERVER_USER = 'anonymous';
    
    const FTP_SERVER_MAIL = 'weather.guy.bundle@weather.com';
    
    protected $server;
    
    protected $path;
    
    protected $conn;
    
    public function __construct($server, $path)
    {
        $this->server   = $server;
        $this->path     = $path;
    }
    
    public function getServer()
    {
        return $this->server;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function connect()
    {
        if (null !== $this->conn) {
            return $this->conn;
        }
        
        $this->conn = ftp_connect($this->getServer());
        if (false === ftp_login($this->conn, self::FTP_SERVER_USER, self::FTP_SERVER_MAIL)) {
            ftp_close($conn);
            throw new \Exception("Connection with '{$this->server}' refused.");
        }
        
        return true;
    }
    
    public function disconnect()
    {
        return ftp_close($this->conn);
    }
    
    public function downloadDailyWeatherTo($year, $temporalDirectory, $compressDelete = true)
    {
        $fileLocalName = $year . ".CSV.gz";
        $fileRemoteName = $this->getPath() . '/' . $fileLocalName;

        $handle = fopen($temporalDirectory . '/' . $fileLocalName, 'w');
        if (false === ftp_fget($this->conn, $handle, $fileRemoteName, FTP_BINARY)) {
            fclose($handle);
            throw new \Exception("Error downloading year '$year'.");
        }
        fclose($handle);

        $compressFilename = $temporalDirectory . '/' .  $fileLocalName;
        $compressFile = gzopen($compressFilename, 'rb');
        if (false === $compressFile) {
            throw new \Exception("Error decompressing year '$year'.");
        }
        $outFilename = $temporalDirectory . '/' . $year . '.csv';
        $outFile = fopen($outFilename, 'wb');

        // Keep repeating until the end of the input file
        while(!gzeof($compressFile)) {
            // Read buffer-size bytes
            // Both fwrite and gzread and binary-safe
            fwrite($outFile, gzread($compressFile, 4096));
        }

        // Files are done, close files
        fclose($outFile);
        gzclose($compressFile);
        
        if (true === $compressDelete) {
            unlink($compressFilename);
        }
        
        // TODO: Delete uncompressFile
        return $outFilename;
    }
}
