<?php
    
	
	    /*
	    Copyright 2008, 2009, 2010, 2011 Patrik Hultgren
	    
	    YOUR PROJECT MUST ALSO BE OPEN SOURCE IN ORDER TO USE THIS VERSION OF PHP IMAGE EDITOR.
	    BUT YOU CAN USE PHP IMAGE EDITOR JOOMLA PRO IF YOUR CODE NOT IS OPEN SOURCE.
	    
	    This file is part of PHP Image Editor Normal.
	
	    PHP Image Editor Normal is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.
	
	    PHP Image Editor Normal is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with PHP Image Editor Normal. If not, see <http://www.gnu.org/licenses/>.
	    */
	

    define("IMAGE_MAX_WIDTH", 900);
	define("IMAGE_MAX_HEIGHT", 1400);
	define("DEFUALT_LANGUAGE", "pt-BR");
	define("RELOAD_PARENT_BROWSER_ON_SAVE", false);
	define("AJAX_POST_TIMEOUT_MS", 20000);
    
	define("RESIZE_ENABLED", true);
	define("ROTATE_ENABLED", true);
	define("CROP_ENABLED", true);
	define("EFFECTS_ENABLED", true);
	
	/*	
		START_PANEL can have any of these values.
		The panel must be enabled which is set above.
		
		MENU_RESIZE
		MENU_ROTATE
		MENU_CROP
		MENU_EFFECTS
	*/
	define("START_PANEL", MENU_RESIZE);
	
?>