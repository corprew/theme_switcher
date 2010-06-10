<?php
/*///////////////////////////////////////////////////////////
NAME:savetheme
PURPOSE: This script recieves data from the theme_switcher block, 
saves the selected theme to the users profile, 
and returns the user to their previous location
AUTHOR: David Jackson
CONTACT: davidj@stcuthberts.school.nz
///////////////////////////////////////////////////////////*/

//INCOMING POST VARIABLES: theme, location

//include relevant libraries
require_once("../../config.php");
//these libs don't seem to be needed
//include($CFG->wwwroot."/lib/datalib.php");
//include($CFG->wwwroot."/lib/weblib.php");
//include($CFG->wwwroot."/lib/moodlelib.php");
//include($CFG->wwwroot."/lib/dmlib.php");

//define variables
if($_POST['theme']){$theme=$_POST['theme'];}else{$theme=$CFG->theme;}
if($_POST['location']){$location=$_POST['location'];}else{$location=$CFG->wwwroot.'/';}
$id = $USER->id;

//update user profile
if(has_capability('moodle/user:editownprofile',$USER)){ //changes by vinay 
	$sql="UPDATE mdl_user SET theme = '$theme' WHERE id = '$USER->id'";
	$db->Execute($sql); 
	//any of the following functions also work ($db->Execute is most portable)
	//pg_query($sql);
	//execute_sql($sql); 

	//output for testing
	/*
	echo '<h2>Updating profile</h2>';
	echo 'Running query: '.$sql.'<br />';
	echo 'to update profile of '.$USER->username.' to use '.$theme;
	echo ' and returning to <a href="'.$CFG->wwwroot.$location.'">'.$CFG->wwwroot.$location.'</a><br /><br />';
	*/

	//update $SESSION with the preferred theme
	$USER->theme=$theme;
	$_SESSION['USER']=$USER;

	//check contents of session
	/* 
	foreach($_SESSION as $itemname => $itemvalue){
	echo "<b>$itemname:</b><br /><br />";
	foreach($itemvalue as $name => $value){
	echo $name.': '.$value.'<br />';
	}
	echo "<br />";
	}
	echo '<a href="'.$location.'">Click here to return</a>';
	*/

	}else{ error("You are not allowed to do that");
}

//return to original location 
redirect($location);

?>