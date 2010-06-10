<?PHP //$Id$

class block_theme_switcher extends block_base {
	function init() {
		$this->title = 'Theme Switcher'; //get_string('switchtheme');
		$this->version = 2010011000;
	}

	function applicable_formats() {
	return array('all' => true);//,'site' => true);
	}

	function get_content () {
		global $USER, $CFG, $course;

		//get list of themes
		$themes[''] = get_string('default'); 
		$themes += get_list_of_themes();
                $USER->theme = NULL;
		$thememenu = choose_from_menu($themes, 'theme',$USER->theme, "", "", "","true");

		if ($this->content !== NULL) {
			return $this->content;
		}

		$username = get_moodle_cookie() === 'nobody' ? '' : get_moodle_cookie();

		$location = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

		$this->content->footer = '';
		$this->content->text = '';
                $USER->loggedin = NULL;
		if (($USER->loggedin or !isguest()) and !empty($CFG->allowuserthemes)) { // Show the block
			//display a simple form to switch the theme
			$this->content->text .= '<form class="theme_switcher_form" name="themeswitch" method="post" action="'.$CFG->wwwroot.'/blocks/theme_switcher/savetheme.php">'; 
			//$this->content->text .= '<table align="center" cellpadding="0" cellspacing="0" class="theme_switcher_table"><tr><td>';
			$this->content->text .= '<ul style="list-style-type: none;"><li>'; // Added style here as bullets sometimes appear even though in defined in styles.php
			$this->content->text .= choose_from_menu($themes, 'theme', $USER->theme, "", "", "","true");
			$this->content->text .= '</li><li>';
			$this->content->text .= '<input type="submit" value="Save" />';

			//hidden fields to tell the user edit form who we are/where we came from
			//$this->content->text .= '<input type="hidden" name="id" value="'.$USER->id.'" />';//replaced with $USER->id
			$this->content->text .= '<input type="hidden" name="location" value="'.$location.'" />';

			//finish the form 
			//$this->content->text .= '</td></tr></table></form>';
			$this->content->text .= '</li></ul></form>';

			//text for footer
			//$this->content->footer .= 'You are here: '.$location.'<br />';
			//$this->content->footer .= 'Select your preferred theme';
		}else{ 
			//if guest or not logged in, hide block completely
			$this->content = ""; 
		}

		//print the content
		return $this->content;
	}
}

?>
