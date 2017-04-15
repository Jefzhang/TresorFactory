<?php
/*
 * Editor server script for DB table activityList
 * Created by http://editor.datatables.net/generator
 */

// DataTables PHP library and database connection
require("/Applications/XAMPP/xamppfiles/htdocs/project/data/evenement.php");
require("/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php");
session_name("tresor");
session_start();
$login;
$pemitted=false;
$maxId;
if(isset($_SESSION['login'])){
	//$dbh = Database::connect();
	//$login = $_SESSION['login'];
	$pemitted = true;
	//$maxId = Evenement::getMaxid($dbh)[0];
}
//else $login = null;

//require("/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php");
include( "/Applications/XAMPP/xamppfiles/htdocs/project/php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	//DataTables\Editor\Join,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

// The following statement can be removed after the first run (i.e. the database
// table has been created). It is a good idea to do this to help improve
// performance.
/*$db->sql( "CREATE TABLE IF NOT EXISTS `activityList` (
	`id` int(10) NOT NULL auto_increment,
	`name` varchar(255),
	`date` date,
	`description` varchar(255),
  `recette` numeric(9,2),
	`depence` numeric(9,2),
	`profit` numeric(9,2),
	PRIMARY KEY( `id` )
);" );*/
//$dbh = Database::connect();

// Build our Editor instance and process the data coming from _POST
if($pemitted){
Editor::inst( $db, 'demande')
	->fields(
    //Field::inst('activityList.id'),
		Field::inst( 'binet' )
      ->setValue($_SESSION['login']),
			//->validator( 'Validate::notEmpty' ),
		Field::inst( 'date' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::dateFormat', array( 'format'=>'Y-m-d' ) )
			->getFormatter( 'Format::date_sql_to_format', 'Y-m-d' )
			->setFormatter( 'Format::date_format_to_sql', 'Y-m-d' ),
		Field::inst( 'type' )
			->validator( 'Validate::notEmpty' ),
      Field::inst( 'somme' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'part' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
    Field::inst('asomme')
      ->setValue('-1'),
		Field::inst( 'lsomme' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
    Field::inst('lasomme')
      ->validator('Validate::notEmpty')
      ->validator('Validate::numeric')
	)
  ->where('binet',$_SESSION['login'],'=')

	->process( $_POST )
	->json();}


 ?>
