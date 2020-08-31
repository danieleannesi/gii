<?php
require 'include/database.php'; 
// 


// DB table to use
$table = 'scofor';
 
// Table's primary key
$primaryKey = 'sco_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier - in this case object
// parameter names
$columns = array( 
    array('db' => 'sco_id', 'dt' => 'sco_id'),
    array( 'db' => 'scf_marca', 'dt' => 'scf_marca' ),
    array( 'db' => 'scf_tipo',  'dt' => 'scf_tipo' ),
    array( 'db' => 'scf_listino', 'dt' => 'scf_listino', 'formatter' => function( $d, $row ) {
        return  htmlspecialchars($d);
    } ), 
    array( 'db' => 'scf_codfor', 'dt' => 'scf_codfor' ),
    array( 'db' => 'scf_da_articolo', 'dt' => 'scf_da_articolo' ),
    array( 'db' => 'scf_a_articolo', 'dt' => 'scf_a_articolo' ) 
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
$where = "scf_eliminato = 0";
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$where )
);
 

?>