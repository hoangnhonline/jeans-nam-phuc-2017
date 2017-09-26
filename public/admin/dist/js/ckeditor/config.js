/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
var strPlugins = 'uploadimage';
var toolbar = [
    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: ['Image', 'Bold', 'Italic', 'Strike',  'Underline', 'Subscript', 'Superscript', 'NumberedList', 'BulletedList', 'Link', 'Unlink' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'Undo', 'Redo', 'HorizontalRule', 'Outdent', 'Indent', 'SpecialChar'] },                                 
    { name: 'styles', items: ['TextColor', 'BGColor', 'Styles', 'Format' ] },
    { name: 'tools', items: [  'Table','Maximize' ] },      
    { name: 'about', items: [ 'About' ] }                
];
CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	CKEDITOR.config.filebrowserBrowseUrl = public_url + '/admin/dist/js/kcfinder/browse.php?type=files';
	CKEDITOR.config.filebrowserImageBrowseUrl = public_url + '/admin/dist/js/kcfinder/browse.php?type=images';
	CKEDITOR.config.filebrowserFlashBrowseUrl = public_url +  '/admin/dist/js/kcfinder/browse.php?type=flash';
	CKEDITOR.config.filebrowserUploadUrl = public_url +  '/admin/dist/js/kcfinder/upload.php?type=files';
	CKEDITOR.config.filebrowserImageUploadUrl = public_url +  '/admin/dist/js/kcfinder/upload.php?type=images';	
	CKEDITOR.config.filebrowserFlashUploadUrl = public_url +  '/admin/dist/js/kcfinder/upload.php?type=flash';
	CKEDITOR.config.toolbar = toolbar;
	CKEDITOR.config.htmlEncodeOutput = false;
	CKEDITOR.config.basicEntities = true;
	CKEDITOR.config.extraPlugins = strPlugins;
	CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_P;
	CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
	CKEDITOR.config.language = 'vi';
	CKEDITOR.config.height = 500;
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.config.colorButton_enableMore = true;
};