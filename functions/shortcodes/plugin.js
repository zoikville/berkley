(function ()
{
	tinymce.create("tinymce.plugins.shortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("popup", function ( a, params )
			{
				var popup = params.identifier;
				tb_show("Insert Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "tk_button" )
			{	
				var a = this;
					
				btn = e.createMenuButton("tk_button",
				{
					title: "Insert Shortcode",
					image: "../wp-content/themes/berkley/functions/shortcodes/icon.png",
					icons: false
				});
				
				btn.onRenderMenu.add(function (c, b)
				{
					a.addWithPopup( b, "Featured Box Area", "featured" );
					a.addWithPopup( b, "Subheading", "subheading" );
					a.addWithPopup( b, "Link", "link" );
					a.addWithPopup( b, "Two Column", "columns" );
					a.addWithPopup( b, "Dividing line", "line" );
				});
				
				return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("popup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		}
	});
	
	tinymce.PluginManager.add("shortcodes", tinymce.plugins.shortcodes);
})();