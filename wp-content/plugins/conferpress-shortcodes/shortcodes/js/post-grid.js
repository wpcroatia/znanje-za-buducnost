// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_post_grid', function(editor, url) {
		editor.addButton('shortcode_post_grid', {
			text: '',
			tooltip: 'Post Grid',
			id: 'shortcode_post_grid',
			icon: 'icon-post-grid',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Post Grid',
					body: [
						{type: 'listbox', 
							name: 'column', 
							label: 'Grid Columns Number', 
							'values': [
								{text: '3 Column', value: ''},
								{text: '2 Column', value: '2'},
								{text: '4 Column', value: '4'},
							]
						},
						{type: 'listbox', 
							name: 'post_type', 
							label: 'Post Type', 
							'values': [
								{text: 'Post', value: 'post'},
								{text: 'Tribe Events', value: 'tribe_events'},
								{text: 'Product', value: 'product'},
								{text: 'Attachment', value: 'attachment'}
							]
						},
						{type: 'textbox', name: 'cat', label: 'Category (List of cat ID or slug)'},
						{type: 'textbox', name: 'tag', label: 'Tags (List of tags, separated by a comma)'},
						{type: 'textbox', name: 'ids', label: 'Ids (Specify post IDs to retrieve)'},
						{type: 'textbox', name: 'number', label: 'Count (Number of posts to show)'},
						{type: 'listbox', 
							name: 'order', 
							label: 'Order', 
							'values': [
								{text: 'DESC', value: 'DESC'},
								{text: 'ASC', value: 'ASC'}
							]
						},
						{type: 'listbox', 
							name: 'orderby', 
							label: 'Order by', 
							'values': [
								{text: 'Date', value: 'date'},
								{text: 'ID', value: 'ID'},
								{text: 'Author', value: 'author'},
								{text: 'Title', value: 'title'},
								{text: 'Name', value: 'name'},
								{text: 'Modified', value: 'modified'},
								{text: 'Parent', value: 'parent'},
								{text: 'Random', value: 'rand'},
								{text: 'Comment count', value: 'comment_count'},
								{text: 'Menu order', value: 'menu_order'},
								{text: 'Meta value', value: 'meta_value'},
								{text: 'Meta value num', value: 'meta_value_num'},
								{text: 'Post__in', value: 'post__in'},
								{text: 'None', value: 'none'}
							]
						},
						{type: 'textbox', name: 'meta_key', label: 'Meta key (Name of meta key for ordering)'},
						{type: 'listbox', 
							name: 'event_display', 
							label: 'Event display (Only work with post type is Event)', 
							'values': [
								{text: 'Upcoming', value: ''},
								{text: 'Recent', value: 'past'},
								{text: 'Custom', value: 'custom'}
							]
						},
						{type: 'listbox', 
							name: 'startdate', 
							label: 'Event display custom start date', 
							'values': [
								{text: 'Week ago', value: 'week'},
								{text: 'Month ago', value: 'month'},
								{text: 'Year ago', value: 'year'}
							]
						},
						{type: 'listbox', 
							name: 'enddate', 
							label: 'Event display custom end date', 
							'values': [
								{text: 'Next Week', value: 'week'},
								{text: 'Next Month', value: 'month'},
								{text: 'Next Year', value: 'year'},
							]
						},
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
						editor.insertContent('[sc_post_grid column="'+e.data.column+'" post_type="'+e.data.post_type+'" cat="'+e.data.cat+'" tag="'+e.data.tag+'" ids="'+e.data.ids+'" count="'+e.data.number+'" order="'+e.data.order+'" orderby="'+e.data.orderby+'" meta_key="'+e.data.meta_key+'" event_display="'+e.data.event_display+'" startdate="'+e.data.startdate+'" enddate="'+e.data.enddate+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
