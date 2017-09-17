/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
var toolbar = [
    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: ['Image', 'Bold', 'Italic', 'Underline', 'Subscript', 'Superscript', 'NumberedList', 'BulletedList', 'Link', 'Unlink' ] },                             
    { name: 'styles', items: [ 'Format' ] },
    { name: 'tools', items: [ 'Maximize' ] },                      
];
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
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

};