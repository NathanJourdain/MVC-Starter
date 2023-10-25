<?php
namespace App\Config;

use PDO;
use PDOException;

final class PDOConnexion {
	//Instance de la class PDOConnexion
	private static $instance;
	private static $type = "sqlite";
	private static $host = 'data.db';
	private static $dbname = null;
	private static $user = null;
	private static $pwd = null;
	private $dbh = null;
	private function __construct()
    {
        try{
        	$this->dbh = new PDO(
                self::$type.':'.self::$host, 
                self::$user,self::$pwd,
                array(PDO::ATTR_PERSISTENT => true)
            );
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
        }
        catch(PDOException $e){
            echo "<p>Erreur !: ".$e->getMessage()."</p>";
            die();
        }
    }
    public function __destruct(){
    	if(!is_null($this->dbh)){
    		$this->dbh=null;
    		self::$instance=null;
    	}
    }
    public static function getInstance(){
    	if(!isset(self::$instance)){
    		self::$instance=new PDOConnexion();
    		return self::$instance->dbh;
    	}
        else return self::$instance->dbh;
    }
    public static function setParameters($_dbname, $_user, $_pwd){
    	self::$dbname=$_dbname;
    	self::$user=$_user;
    	self::$pwd=$_pwd;
    }
}


?>