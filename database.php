<?php 
 
class Database 
{
    
    private static $dbHost = "localhost"; 
    private static $dbName = "burgercode_fini";
    private static $dbUser = "root";
    private static $dbUserpassword = "";
    
    private static $connection = null;

     public static function connect() 
     {
       
             try
        {
           self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName,self::$dbUser,self::$dbUserpassword);   
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        } 
         
         return self::$connection;  
     }
    
      public static function disconnect()
      {
          self::$connection = null;
      }
}
 
Database::connect();
 

?> 










