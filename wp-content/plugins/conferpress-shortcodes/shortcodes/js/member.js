// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_member', function(editor, url) {
		editor.addButton('shortcode_member', {
			text: '',
			tooltip: 'Member',
			id: 'member_shortcode',
			icon: 'icon-member',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Member',
					body: [
						{type: 'textbox', name: 'id', label: 'ID'},
						{type: 'listbox', 
							name: 'image_position', 
							label: 'Image Position', 
							'values': [
								{text: 'Top', value: ''},
								{text: 'Bottom', value: 'bottom'},
							]
						},
					],
					onsubmit: function(e) {
						var uID =  Math.floor((Math.random()*100)+1);
						// Insert content when the window form is submitted
						editor.insertContent('[member id="'+e.data.ids+'" image_position="'+e.data.image_position+'"]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
