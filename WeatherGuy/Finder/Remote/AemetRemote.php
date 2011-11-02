<?php

namespace Ideup\WeatherGuyBundle\WeatherGuy\Finder\Remote;

class AemetRemote
{
    const FTP_SERVER_USER = 'anonymous';
    
    const FTP_SERVER_MAIL = 'weather.guy.bundle@weather.com';
    
    protected $server;
    
    protected $path;
    
    protected $conn;
    
    public function __construct($server, $path)
    {
        $this->server               = $server;
        $this->path                 = $path;
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
    
    public function downloadDailyWeatherTo($years, $temporalDirectory)
    {
        $this->connect();
        
        if (false === is_array($years)) {
            $years = array($years);
        }
        
        foreach($years as $year) {
            $fileLocalName = $year . ".CSV.gz";
            $fileRemoteName = $this->getPath() . '/' . $fileLocalName;
            
            $handle = fopen($temporalDirectory . '/' . $fileLocalName, 'w');
            if (false === ftp_fget($this->conn, $handle, $fileRemoteName, FTP_BINARY)) {
                fclose($handle);
                throw new \Exception("Error downloading year '$year'.");
            }
            fclose($handle);

            $uncompressFile = gzopen($temporalDirectory . '/' .  $fileLocalName, 'rb');
            if (false === $uncompressFile) {
                throw new \Exception("Error decompressing year '$year'.");
            }
            $outFile = fopen($temporalDirectory . '/' . $year . '.csv', 'wb');
            
            // Keep repeating until the end of the input file
            while(!gzeof($uncompressFile)) {
                // Read buffer-size bytes
                // Both fwrite and gzread and binary-safe
                fwrite($outFile, gzread($uncompressFile, 4096));
            }

            // Files are done, close files
            fclose($outFile);
            gzclose($uncompressFile);
        }
        
        $this->disconnect();
        
        return true;
    }
}
