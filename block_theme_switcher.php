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
			$this->content->text .= '<form class="theme_switcher_form" name="themeswitch" method="get" action="'.$CFG->wwwroot.'/blocks/theme_switcher/savetheme.php">';
                        $this->content->text .= '<input type="image" src="/theme/gc_theme_01/icon.png" value="gc_theme_01" name="gc_theme_01">';
                        $this->content->text .= '<input type="hidden" value="gc_theme_01" name="theme">';
                        $this->content->text .= '<input type="hidden" name="sesskey" value="'.sesskey().'" /> ';
			$this->content->text .= '<input type="hidden" name="location" value="'.$location.'" />';
			$this->content->text .= '</form>';
			$this->content->text .= '<form class="theme_switcher_form" name="themeswitch" method="get" action="'.$CFG->wwwroot.'/blocks/theme_switcher/savetheme.php">';
                        $this->content->text .= '<input type="image" src="/theme/gc_theme_02/icon.png" value="gc_theme_02" name="gc_theme_02">';
                        $this->content->text .= '<input type="hidden" value="gc_theme_02" name="theme">';
                        $this->content->text .= '<input type="hidden" name="sesskey" value="'.sesskey().'" /> ';
                        $this->content->text .= '<input type="hidden" name="location" value="'.$location.'" />';
			$this->content->text .= '</form>';
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
