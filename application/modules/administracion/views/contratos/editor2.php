<link href="<?php echo base_url() ?>extras/css/editor2.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/editor-texto2.js" type="text/javascript"></script>
<div class="span11">
<!-- This <div> holds alert messages to be display in the sample page. -->
	<script type="text/javascript">
	//<![CDATA[

// When opening a dialog, its "definition" is created for it, for
// each editor instance. The "dialogDefinition" event is then
// fired. We should use this event to make customizations to the
// definition of existing dialogs.
CKEDITOR.on( 'dialogDefinition', function( ev )
	{
		// Take the dialog name and its definition from the event
		// data.
		var dialogName = ev.data.name;
		var dialogDefinition = ev.data.definition;

		// Check if the definition is from the dialog we're
		// interested on (the "Link" dialog).
		if ( dialogName == 'link' )
		{
			// Get a reference to the "Link Info" tab.
			var infoTab = dialogDefinition.getContents( 'info' );

			// Add a text field to the "info" tab.
			infoTab.add( {
					type : 'text',
					label : 'My Custom Field',
					id : 'customField',
					'default' : 'Sample!',
					validate : function()
					{
						if ( /\d/.test( this.getValue() ) )
							return 'My Custom Field must not contain digits';
					}
				});

			// Remove the "Link Type" combo and the "Browser
			// Server" button from the "info" tab.
			infoTab.remove( 'linkType' );
			infoTab.remove( 'browse' );

			// Set the default value for the URL field.
			var urlField = infoTab.get( 'url' );
			urlField['default'] = 'www.example.com';

			// Remove the "Target" tab from the "Link" dialog.
			dialogDefinition.removeContents( 'target' );

			// Add a new tab to the "Link" dialog.
			dialogDefinition.addContents({
				id : 'customTab',
				label : 'My Tab',
				accessKey : 'M',
				elements : [
					{
						id : 'myField1',
						type : 'text',
						label : 'My Text Field'
					},
					{
						id : 'myField2',
						type : 'text',
						label : 'Another Text Field'
					}
				]
			});

			// Rewrite the 'onFocus' handler to always focus 'url' field.
			dialogDefinition.onFocus = function()
			{
				var urlField = this.getContentElement( 'info', 'url' );
				urlField.select();
			};
		}
	});

	//]]>
	</script>
<div id="alerts">
	<noscript>
		<p>
			<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
			support, like yours, you should still see the contents (HTML data) and you should
			be able to edit it normally, without a rich editor interface.
		</p>
	</noscript>
</div>
<form action="<?php echo base_url() ?>administracion/contratos/guardar_contrato" method="post">
		<input type="text" name="nb_contrato" placeholder="Nombre del contrato" style="width: 948px;font-family: Arial;" value="<?php if(isset($texto)){ echo ucwords( mb_strtolower($texto->nombre, 'UTF-8'));} ?>" />
		<br /><br />
		<select name="planta">
			<option value="">Seleccione Planta</option>
			<?php foreach ($lista_planta as $lp) { ?>
				<option value="<?php echo $lp->id ?>" <?php if(isset($texto)){ if($lp->id == $texto->id_empresa_planta){ echo " selected"; } } ?> ><?php echo ucwords( mb_strtolower( $lp->nombre, 'UTF-8' ) ) ?></option>
			<?php } ?>
		</select>
		<br /><br />
		<textarea cols="80" id="editor1" name="txt_contrato" rows="10"><?php if(isset($texto)){ echo $texto->texto;} ?></textarea>
		<script type="text/javascript">
		//<![CDATA[
			// Replace the <textarea id="editor1"> with an CKEditor instance.
			var editor = CKEDITOR.replace( 'editor1',
				{
					// Defines a simpler toolbar to be used in this sample.
					// Note that we have added out "MyButton" button here.
					toolbar : [ [ 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike','Subscript','Superscript','-','Link', '-', 'MyButton' ],
								[ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ],
								[ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ],
								[ 'Styles','Format','Font','FontSize'],
								[ 'Find','Replace','-','SelectAll','-','Scayt' ],
								[ 'Image','Flash','Table','SpecialChar','PageBreak'] ]
				});

			// Listen for the "pluginsLoaded" event, so we are sure that the
			// "dialog" plugin has been loaded and we are able to do our
			// customizations.
			editor.on( 'pluginsLoaded', function( ev )
				{
					// If our custom dialog has not been registered, do that now.
					if ( !CKEDITOR.dialog.exists( 'myDialog' ) )
					{
						// We need to do the following trick to find out the dialog
						// definition file URL path. In the real world, you would simply
						// point to an absolute path directly, like "/mydir/mydialog.js".
						//var href = document.location.href.split( '/' );
						//href.pop();
						//href.push( 'api_dialog', 'my_dialog.js' );
						//href = href.join( '/' );
						var href = base_url+'extras/js/ckeditor/api_dialog/my_dialog.js';

						// Finally, register the dialog.
						CKEDITOR.dialog.add( 'myDialog', href );
					}

					// Register the command used to open the dialog.
					editor.addCommand( 'myDialogCmd', new CKEDITOR.dialogCommand( 'myDialog' ) );

					// Add the a custom toolbar buttons, which fires the above
					// command..
					editor.ui.addButton( 'MyButton',
						{
							label : 'My Dialog',
							command : 'myDialogCmd'
						} );
				});
		//]]>
		</script>
		<br />
		<input type="hidden" name="id_contrato" value="<?php if(isset($texto)){ echo $texto->id;} ?>" />
		<button id="btn_guardar" type="submit" class="btn primary">
			Guardar
		</button>
</form>
</div>