wp.domReady( function() {
	var el = wp.element.createElement,
		registerBlockType = wp.blocks.registerBlockType,
		RichText = wp.editor.RichText;

	registerBlockType( 'custom/paragraph', { // core/paragraph ブロックを置き換える
		title: '文章', // カスタム段落ブロックのタイトル
		icon: 'editor-paragraph',
		category: 'common', // 共通カテゴリに分類
		attributes: {
			content: {
				type: 'string',
				source: 'html',
				selector: 'p',
			},
		},
		edit: function( props ) {
			var allowedFormats = [ 'core/bold', 'core/link' ]; // bold と link のみを許可

			return el(
				RichText,
				{
					tagName: 'p',
					value: props.attributes.content,
					onChange: function( newValue ) {
						props.setAttributes( { content: newValue } );
					},
					allowedFormats: allowedFormats,
					placeholder: '文章を入れてください。太文字とリンクが使えます。',
				}
			);
		},
		save: function( props ) {
			return el( RichText.Content, {
				tagName: 'p',
				value: props.attributes.content,
			} );
		},
	} );
} );
