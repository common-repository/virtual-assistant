// JavaScript Document
(function () {
	tinymce.PluginManager.add('realcrypto', function (editor, url) {

		editor.addButton('realcrypto', {
			text: '',
            id: 'realcrypto_shortcode',
			tooltip: 'Ultimate Crypto Widgets Shortcode',
			image: VIRTUAL_ASSISTANT_ICON.VIRTUAL_ASSISTANT_ICON,
			onclick: function () {
				// Open window
                var body = [
						{
							type: 'listbox',
							name: 'id',
							label: 'Ultimate Crypto Widgets',
							'values': VIRTUAL_ASSISTANT_SHORTCODE,
						},
					];

				body = body.concat();

				editor.windowManager.open({
					title: 'Ultimate Crypto Widgets',
					body: body,
					onsubmit: function (e) {

						var id = e.data.id;

						editor.insertContent('[crypto_widgets id="'+id+'"]');
					}
				});
			}
		});
		
	});

})();
