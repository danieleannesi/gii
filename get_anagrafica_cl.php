<?php
require 'include/database.php'; 
// 
$cf_cod = $_POST["cf_cod"];
if($cf_cod){
    $res=array();
    $qr="SELECT * FROM clienti WHERE cf_cod='$cf_cod'";
    $rst=mysql_query($qr,$con);
    while($row = mysql_fetch_assoc($rst)) {
       $res=$row;
    }

    header('Content-Type: application/json');
    echo json_encode($res);

} else {
    // DB table to use
    $table = 'clienti';
 
    // Table's primary key
    $primaryKey = 'cf_cod';
    
    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier - in this case object
    // parameter names
    $columns = array( 
        array('db' => 'cf_cod', 'dt' => 'cf_cod'),
        array( 'db' => 'cf_cli_for', 'dt' => 'cf_cli_for' ),
        array( 'db' => 'cf_tipo',  'dt' => 'cf_tipo' ),
        array( 'db' => 'cf_ragsoc', 'dt' => 'cf_ragsoc'),  
        array( 'db' => 'cf_piva', 'dt' => 'cf_piva' ),
        array( 'db' => 'cf_codfisc', 'dt' => 'cf_codfisc' ),
        array( 'db' => 'cf_telefono', 'dt' => 'cf_telefono' )  
    );
    
    $sql_details = array(
        'user' => $DB_USER,
        'pass' => $DB_PASS,
        'db'   => $DB_NAME,
        'host' => $DB_SERVER
    ); 
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * If you just want to use the basic configuration for DataTables with PHP
    * server-side, there is no need to edit below this line.
    */
    $where = "cf_cli_for = 1";
    require( 'ssp.class.php' );
    
    echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$where )
    );
}

 

?>