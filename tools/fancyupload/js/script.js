/**
 * FancyUpload Showcase
 *
 * @license		MIT License
 * @author		Harald Kirschner <mail [at] digitarald [dot] de>
 * @copyright	Authors
 */

window.addEvent('domready', function() {

	/**
	 * Uploader instance
	 */
	var up = new FancyUpload3.Attach('demo-list', '#demo-attach, #demo-attach-2', {
		path: 'http://localhost/emsproj/tools/fancyupload/js/Swiff.Uploader.swf',
		url: 'http://localhost/emsproj/tools/fancyupload/script.php?type=test&kid=29',
		fileSizeMax: 20 * 1024 * 1024,
		
		verbose: true,
		
		onSelectFail: function(files) {
			files.each(function(file) {
				new Element('li', {
					'class': 'file-invalid',
					events: {
						click: function() {
							this.destroy();
						}
					}
				}).adopt(
					new Element('span', {html: file.validationErrorMessage || file.validationError})
				).inject(this.list, 'bottom');
			}, this);	
		},
		
		onFileSuccess: function(file) {
			new Element('input', {type: 'checkbox', 'checked': true,'title':'Del' }).inject(file.ui.element, 'top');
			//new Element('<a href="../../pic_here/'+file.name+'" target="_blank">D</a><img src="" height="10" width="10" onClick="PG_Del_Go(\''+file.name+'\');">').inject(file.ui.element, 'top');
			//真麻煩…要自已改套件…= = 
			file.ui.element.highlight('#e6efc2');
		},
		
		onFileError: function(file) {
			file.ui.cancel.set('html', 'Retry').removeEvents().addEvent('click', function() {
				file.requeue();
				return false;
			});
			
			new Element('span', {
				html: file.errorMessage,
				'class': 'file-error'
			}).inject(file.ui.cancel, 'after');
		},
		
		onFileRequeue: function(file) {
			file.ui.element.getElement('.file-error').destroy();
			
			file.ui.cancel.set('html', 'Cancel').removeEvents().addEvent('click', function() {
				file.remove();
				return false;
			});
			
			this.start();
		}
		
	});

});
function PG_Del_Go(name){
	alert(name);
}