<?php 

include 'config.php';

$tube_id = $_GET['tube_id'];

# Connexion à PostgreSQL
$conn = pg_connect("dbname='" . $pg_db . "' user='" . $pg_lgn . "' password='" . $pg_pwd . "' host='" . $pg_host . "'");
if (!$conn) {
    echo "Not connected";
    exit;
}

$sql = "
select 
	id_polluant, nom_polluant, tube_id, tube_nom, id_periode, nom_periode, 
	id_unite, nom_unite, val, val_corrigee
from c_template.mesures as a
left join c_template.polluants as b using (id_polluant)
left join c_template.tubes as c using (tube_id)
left join c_template.mesures_periodes as d using (id_periode)
left join c_template.unites as e using (id_unite)
where 
	tube_id = " . $tube_id . "
	and id_polluant in (2,3,4,5,6)
order by id_polluant, tube_id, id_periode;
";


$res = pg_query($conn, $sql);
if (!$res) {
    echo "An SQL error occured.\n";
    exit;
}

$myarray = array();
while ($row = pg_fetch_assoc( $res )/*pg_fetch_row($contests)*/) {
  $myarray[] = $row;
}
header('Content-Type: application/json');
echo json_encode($myarray);

?>