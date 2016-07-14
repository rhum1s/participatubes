<?php 

/* Récupération de variables 
if (isset($_POST['tube_nom'])) {
    $tube_nom = strip_tags($_POST['tube_nom']);
    $tube_type = strip_tags($_POST['tube_type']);   
};
*/
    
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$nom = $_POST['nom'];
$type = $_POST['type'];
    
/* Chargement du fichier de config en fonction de l'utilisateur */
if ($user == "admin") {
    include 'config_su.php';
} else {
    include 'config.php';
}    

/* Connexion à PostgreSQL */
$conn = pg_connect("dbname='" . $pg_db . "' user='" . $pg_lgn . "' password='" . $pg_pwd . "' host='" . $pg_host . "'");
if (!$conn) {
    echo "Not connected";
    exit;
}

/* Insertion du tube */
$sql = "
insert into c_template.tubes (tube_id, tube_nom, typo_id, tube_ville, geom) 
select 
	max(tube_id) + 1 as tube_id,
	'".$nom."' as tube_nom,
	(SELECT typo_id FROM c_template.tubes_typos WHERE typo_description = '".$type."') as typo_id,
	'TODO!' as tube_ville,
	ST_Transform(ST_SetSrid(ST_MakePoint(".$lng.", ".$lat."), 4326), 2154)
from c_template.tubes;
";

$res = pg_query($conn, $sql);
if (!$res) {
    echo "Erreure de mise à jour.";
    exit;
}

echo "Tube ".$nom." inséré.";
?>    
