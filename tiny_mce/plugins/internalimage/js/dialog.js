var extensions = new Array('jpg', 'jpeg', 'png', 'gif');
var filePath = '../../../logo/file.png';
var mcePath = '../../../mediatheque';
var realPath = 'mediatheque';

var InternalImageDialog = {
	insert : function( filename ) {
		// Insert the contents from the input into the document
		var nomFichier = filename.split('.');
		var exist = false;
		for (key in extensions) {
            if (nomFichier[1] == extensions[key]) {
                exist = true;
            }
        }
		if (exist == true)
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<img src="' + realPath + '/' + filename + '" />');
		else
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<a href="' + realPath + '/' + filename + '">' + filename + '</a>');
		tinyMCEPopup.close();
	},
	
	preview : function( filename ) {
		var nomFichier = filename.split('.');
		var exist = false;
		for (key in extensions) {
            if (nomFichier[1] == extensions[key]) {
                exist = true;
            }
        }
		if (exist == true)
			document.preview.src = mcePath + '/' + nomFichier[0] + '_petit.' + nomFichier[1];
		else
			document.preview.src = filePath;
	}
};
