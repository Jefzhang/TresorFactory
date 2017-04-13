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
	$dbh = Database::connect();
	$login = $_SESSION['login'];
	$pemitted = true;
	$maxId = Evenement::getMaxid($dbh)[0];
}
else $login = null;

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
Editor::inst( $db, 'activityList')
	->fields(
    //Field::inst('activityList.id'),
		Field::inst( 'name' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'date' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::dateFormat', array( 'format'=>'d-m-y' ) )
			->getFormatter( 'Format::date_sql_to_format', 'd-m-y' )
			->setFormatter( 'Format::date_format_to_sql', 'd-m-y' ),
		Field::inst( 'description' )
			->validator( 'Validate::notEmpty' ),
      Field::inst( 'recette' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'depence' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'profit' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' )


	)

  /*->join(
		  Join::inst('binetActivity','array')
			    ->link('activityList.id','binetActivity.id')

		)*/


	/*->on('preCreate',function($editor,$values){
		global $maxId;
		$maxId = $maxId +1;
		$editor->field('binetActivity.binet')
		     //->set(Field::SET_CREATE)
		     ->setValue($_SESSION['login']);
		$editor->field('binetActivity.eveId')
	  //new Field('binetActivity.eveId')
		    // ->set(Field::SET_CREATE)
				 ->setValue($maxId);
	})*/


	//

	->process( $_POST )
	->json();}



 ?>
