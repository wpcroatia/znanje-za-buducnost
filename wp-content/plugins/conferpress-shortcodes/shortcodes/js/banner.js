// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_banner', function(editor, url) {
		editor.addButton('shortcode_banner', {
			text: '',
			tooltip: 'Banner',
			id: 'banner_shortcode',
			icon: 'icon-banner',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Banner',
					body: [
						{type: 'textbox', name: 'number', label: 'Number of Banner'},
						{type: 'listbox', 
							name: 'css_animation', 
							label: 'CSS Animation', 
							'values': [
								{text: 'No', value: ''},
								{text: 'Top to bottom', value: 'top-to-bottom'},
								{text: 'Bottom to top', value: 'bottom-to-top'},
								{text: 'Left to right', value: 'left-to-right'},
								{text: 'Right to left', value: 'right-to-left'},
								{text: 'Appear from center', value: 'appear'}
							]
						},
						{type: 'textbox', name: 'animation_delay', label: 'Animation Delay'},
					],
					onsubmit: function(e) {
						var uID =  Math.floor((Math.random()*100)+1);
						var number = e.data.number?e.data.number:2;
						var shortcode_output ='[sc_banner number="'+e.data.number+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]';
						for(i=0; i<number; i++){
							shortcode_output +='[sc_banner_item small_title="Small title" title="Banner title" icon="" bg_image="" ]';
						}
						shortcode_output +='[/sc_banner]';
						// Insert content when the window form is submitted
						editor.insertContent(shortcode_output+'<br class="nc"/>');
					}
				});
			}
		});
	});
})();
