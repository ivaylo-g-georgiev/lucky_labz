<?php
define('DB_SERVER','localhost');
define('DB_USER','postgres');
define('DB_PORT','5432');
define('DB_PASS' ,'1234');
define('DB_NAME', 'postgres');

class Postgres_con
{
 function __construct($table)
 {
  // $conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
  $conn = pg_connect("host=" . DB_SERVER . " port=" . DB_PORT . " dbname=" . DB_NAME . " user=" . DB_USER . " password=" . DB_PASS . "") or die('localhost connection problem'.pg_last_error());

  $query = pg_query("SELECT relname FROM pg_class WHERE relname='$table'");
  $result = pg_fetch_result($query, 0);

  if ($result):
    $query = '';
  else:
    $query = 'CREATE TABLE ' . $table . '(ID TEXT PRIMARY KEY,name TEXT NULL,gender TEXT NULL,faculty TEXT NULL,major TEXT NULL,score NUMERIC NULL,DATE DATE DEFAULT CURRENT_DATE,TIME TIME DEFAULT CURRENT_TIME);';
  endif;

  pg_query($query);
 }
 public function select($table_name)
 {
  $res=pg_query("SELECT * FROM $table_name");
  return $res;
 }
 public function import($table,$path)
 {
   $Directory = new RecursiveDirectoryIterator($path);

   $Iterator = new RecursiveIteratorIterator($Directory);

   $Regex = new RegexIterator($Iterator, '/^.+\.xml$/i', RecursiveRegexIterator::GET_MATCH);

  //  $res = '';
   foreach($Regex as $key => $value){
     $xml=simplexml_load_file($key) or die("Error: Cannot create object");
     foreach($xml->student as $item)
     {
       $check = pg_fetch_result(pg_query("SELECT EXISTS (SELECT true FROM $table WHERE name='$item->name')"),0);
       if( $check != 't' ):
         $student_faculty_number = $item->attributes();

         $query = "INSERT INTO $table VALUES ('$student_faculty_number','$item->name','$item->gender','$item->faculty','$item->major','$item->score',DEFAULT);";
         $res .= pg_query($query);
       else:
         $query = "UPDATE $table SET DATE=DEFAULT";
         $res .= pg_query($query);
       endif;
     }
   }
   return $res;
 }
 public function search($table,$student)
 {
  $query = pg_query("SELECT * FROM $table WHERE LOWER(name) LIKE LOWER('%$student%')");
  $res = pg_fetch_all($query);
  return $res;
 }
}

?>
