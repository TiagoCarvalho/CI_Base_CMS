<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin</title>
<link rel="stylesheet" href="<?=base_url(); ?>public/backend/css/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url(); ?>public/backend/css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url(); ?>public/backend/css/invalid.css" type="text/css" media="screen" /> 
	
<script type="text/javascript" src="<?=base_url(); ?>public/backend/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>public/backend/js/simpla.jquery.configuration.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>public/backend/js/facebox.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>public/backend/js/jquery.datePicker.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>public/backend/js/jquery.date.js"></script> 
<script type="text/javascript" src="<?=base_url(); ?>public/backend/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",

		// Theme options Complete
		//plugins : "safari,style,layer,table,save,advhr,advimage,advlink,iespell,insertdatetime,media,directionality,noneditable,nonbreaking,xhtmlxtras,wordcount",
		//theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		//theme_advanced_buttons2 : "cut,copy,paste,pastetext,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,|,forecolor,backcolor",
		//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking ",
		// Theme options simple
		plugins : "safari,advhr,advimage,advlink,iespell,media,directionality,noneditable,nonbreaking",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,blockquote,|,link,unlink,anchor,image",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		content_css : ".public/backend/tinymce/css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "./public/backend/tinymce/lists/template_list.js",
		external_link_list_url : "./public/backend/tinymce/lists/link_list.js",
		external_image_list_url : "./public/backend/tinymce/lists/image_list.js",
		media_external_list_url : "./public/backend/tinymce/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!--[if IE]><script type="text/javascript" src="<?=base_url(); ?>public/backend/js/jquery.bgiframe.js"></script><![endif]-->
<!-- Internet Explorer .png-fix -->
<!--[if IE 6]>
	<script type="text/javascript" src="<?=base_url(); ?>public/backend/js/scripts/DD_belatedPNG_0.0.7a.js"></script>
	<script type="text/javascript">
		DD_belatedPNG.fix('.png_bg, img, li');
	</script>
<![endif]-->
</head>