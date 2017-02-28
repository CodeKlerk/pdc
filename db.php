<?php
class db
{

  function __construct()
  {
    # code...
    $this->dbhost = 'localhost';
    $this->dbuser = 'root';
    $this->dbpass = 'strongpass';
    $this->dbname = 'periodontal';
  }
  function connect(){
    $conn = mysql_connect($this->dbhost, $this->dbuser, $this->dbpass) or die ('Error connecting to mysql');
    mysql_select_db($this->dbname);
    return $conn;
  }
  function insert($table, $data, $exclude = array()) {
    $fields = $values = array();
    if( !is_array($exclude) ) $exclude = array($exclude);
    foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
            $fields[] = "`$key`";
            $values[] = "'" . mysql_real_escape_string($data[$key]) . "'";
        }
    }
    $fields = implode(",", $fields);
    $values = implode(",", $values);
    if( mysql_query("INSERT INTO `$table` ($fields) VALUES ($values)") ) {
        return array( "mysql_error" => false,
                      "mysql_insert_id" => mysql_insert_id(),
                      "mysql_affected_rows" => mysql_affected_rows(),
                      "mysql_info" => mysql_info()
                    );
    } else {
        return array( "mysql_error" => mysql_error() );
    }
  }
  
  function select(){
    $res = array();

    $result = mysql_query("SELECT * FROM tbl_pats") or trigger_error(mysql_error()); 
    while (
    $row = mysql_fetch_array($result)
      ){
      array_push($res, $row);
    }
    if (count($res)>0){return $res; }else{ return false;}
  }
  
}

?>
