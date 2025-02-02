/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbar = [
	{ name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
		{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
		'/',
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
		'/',
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		{ name: 'about', items: [ 'About' ] }
		 
	];

 
//CKEDITOR.config.extraPlugins = 'html5video';
//CKEDITOR.config.extraPlugins = 'html5video,widget,widgetselection,clipboard,lineutils';
CKEDITOR.config.youtube_width = '640';
CKEDITOR.config.youtube_height = '480';	
CKEDITOR.config.youtube_related = true;
CKEDITOR.config.youtube_older = false;
CKEDITOR.config.youtube_privacy = false;
CKEDITOR.config.forceEnterMode = true; 

CKEDITOR.config.extraAllowedContent = 'div(*)';
	 CKEDITOR.config.extraAllowedContent = '*[id]';
	 CKEDITOR.config.extraAllowedContent = 'p(asdf)';
	 CKEDITOR.config.extraAllowedContent = 'style';
	 CKEDITOR.config.extraAllowedContent = '*[id](*)';
	 CKEDITOR.config.extraAllowedContent = 'span;ul;li;table;td;style;*[id];*(*);*{*}';
 	 CKEDITOR.config.extraAllowedContent = 'figure';
    CKEDITOR.config.allowedContent = true; 
	
	CKEDITOR.config.fillEmptyBlocks = false;
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	//config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
