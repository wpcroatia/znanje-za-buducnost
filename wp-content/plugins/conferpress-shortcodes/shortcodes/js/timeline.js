// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_timeline', function(editor, url) {
		editor.addButton('shortcode_timeline', {
			text: '',
			tooltip: 'Timeline',
			id: 'timeline_shortcode',
			icon: 'icon-timeline',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Timeline',
					body: [
						{type: 'textbox', name: 'number', label: 'Number of Timeline'},
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
						var shortcode_output ='[sc_timeline css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]';
						for(i=0; i<number; i++){
							shortcode_output +='[sc_timeline_item title="Timeline item" sub_title="sub title" background="1780" ]This is my timeline item content [/sc_timeline_item]';
						}
						shortcode_output +='[/sc_timeline]';
						// Insert content when the window form is submitted
						editor.insertContent(shortcode_output+'<br class="nc"/>');
					}
				});
			}
		});
	});
})();
