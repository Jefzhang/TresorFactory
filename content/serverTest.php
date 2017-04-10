<?php
/*
 * Editor server script for DB table activityList
 * Created by http://editor.datatables.net/generator
 */

// DataTables PHP library and database connection
session_name("tresor");
session_start();
$login;
if(isset($_SESSION['login'])){
	$login = $_SESSION['login'];
}
else $login = null;

require("/Applications/XAMPP/xamppfiles/htdocs/project/data/database.php");
include( "/Applications/XAMPP/xamppfiles/htdocs/project/php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
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
Editor::inst( $db, 'activityList')
	->fields(
    Field::inst('activityList.id')->set(false),
		Field::inst( 'activityList.name' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'activityList.date' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::dateFormat', array( 'format'=>'d-m-y' ) )
			->getFormatter( 'Format::date_sql_to_format', 'd-m-y' )
			->setFormatter( 'Format::date_format_to_sql', 'd-m-y' ),
		Field::inst( 'activityList.description' )
			->validator( 'Validate::notEmpty' ),
      Field::inst( 'activityList.recette' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'activityList.depence' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'activityList.profit' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' )
	)
	->leftjoin('binetActivity','activityList.id','=','binetActivity.eveId')
	->where('binetActivity.binet',$login,'=')
	->process( $_POST )
	->json();



 ?>
