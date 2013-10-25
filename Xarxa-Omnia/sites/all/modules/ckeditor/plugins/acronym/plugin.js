/**
 * Basic sample plugin inserting acronymeviation elements into CKEditor editing area.
 * Updated to add context menu support and possibility to edit a previously added acronymeviation element.
 */

// Register the plugin with the editor.
// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.plugins.html
CKEDITOR.plugins.add( 'acronym',
{
	// The plugin initialization logic goes inside this method.
	// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.pluginDefinition.html#init
	init: function( editor )
	{
		// Place the icon path in a variable to make it easier to refer to it later.
		// "this.path" refers to the directory where the plugin.js file resides.
		var iconPath = this.path + 'images/icon.png';

		// Define an editor command that inserts an acronymeviation. 
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#addCommand
		editor.addCommand( 'acronymDialog',new CKEDITOR.dialogCommand( 'acronymDialog' ) );
		
		// Create a toolbar button that executes the plugin command. 
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.html#addButton
		editor.ui.addButton( 'Acronym',
		{
			// Toolbar button tooltip.
			label: 'Afegeix un acrònim',
			// Reference to the plugin command name.
			command: 'acronymDialog',
			// Button's icon file path.
			icon: iconPath
		} );
		
		// Add context menu support.
		if ( editor.contextMenu )
		{
			// Register a new context menu group.
			editor.addMenuGroup( 'myGroup' );
			// Register a new context menu item.
			editor.addMenuItem( 'acronymItem',
			{
				// Item label.
				label : 'Edita Acrònim',
				// Item icon path using the variable defined above.
				icon : iconPath,
				// Reference to the plugin command name.
				command : 'acronymDialog',
				// Context menu group that this entry belongs to.
				group : 'myGroup'
			});
			// Enable the context menu only for an <acronym> element.
			editor.contextMenu.addListener( function( element )
			{
				// Get to the closest <acronym> element that contains the selection.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.node.html#getAscendant
				if ( element )
					element = element.getAscendant( 'acronym', true );
				// Return a context menu object in an enabled, but not active state.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.html#.TRISTATE_OFF
				if ( element && !element.isReadOnly() && !element.data( 'cke-realelement' ) )
		 			return { acronymItem : CKEDITOR.TRISTATE_OFF };
				// Return nothing if the conditions are not met.
		 		return null;
			});
		}
		
		// Add a dialog window definition containing all UI elements and listeners.
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.html#.add
		CKEDITOR.dialog.add( 'acronymDialog', function ( editor )
		{
			return {
				// Basic properties of the dialog window: title, minimum size.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.dialogDefinition.html
				title : 'Propietats acrònim',
				minWidth : 400,
				minHeight : 200,
				// Dialog window contents.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.definition.content.html
				contents :
				[
					{
						// Definition of the Basic Settings dialog window tab (page) with its id, label and contents.
						// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.contentDefinition.html
						id : 'tab1',
						label : 'Configuració bàsica',
						elements :
						[
							{
								// Dialog window UI element: a text input field for the acronymeviation text.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.dialog.textInput.html
								type : 'text',
								id : 'acronym',
								// Text that labels the field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.dialog.labeledElement.html#constructor
								label : 'Acrònim (exemple: TIC)',
								// Validation checking whether the field is not empty.
								validate : CKEDITOR.dialog.validate.notEmpty( "acronym field cannot be empty" ),
								// Function to be run when the setupContent method of the parent dialog window is called.
								// It can be used to initialize the value of the field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setValue
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#getText
								setup : function( element )
								{
									this.setValue( element.getText() );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								// Set the element's text content to the value of this field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setText
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#getValue
								commit : function( element )
								{
									element.setText( this.getValue() );
								}
							},
							{
								// Another text input field for the explanation text with a label and validation.
								type : 'text',
								id : 'title',
								label : 'Significat de l\'acrònim (exemple: Tecnologies de la informació i la comunicació)',
								validate : CKEDITOR.dialog.validate.notEmpty( "Explanation field cannot be empty" ),
								// Function to be run when the setupContent method of the parent dialog window is called.
								// It can be used to initialize the value of the field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#getAttribute
								setup : function( element )
								{
									this.setValue( element.getAttribute( "title" ) );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								// Set the element's title attribute to the value of this field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setAttribute
								commit : function( element )
								{
									element.setAttribute( "title", this.getValue() );
								}
							},
							{
								// Another text input field for the explanation text with a label and validation.
								type : 'text',
								id : 'lang',
								label : 'Llengüa de l\'acrònim (exemple: ca)',
								validate : CKEDITOR.dialog.validate.notEmpty( "Explanation field cannot be empty" ),
								// Function to be run when the setupContent method of the parent dialog window is called.
								// It can be used to initialize the value of the field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#getAttribute
								setup : function( element )
								{
									this.setValue( element.getAttribute( "lang" ) );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								// Set the element's lang attribute to the value of this field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setAttribute
								commit : function( element )
								{
									element.setAttribute( "lang", this.getValue() );
								}
							},
	
 
						]
					},
				
				],
				// This method is invoked once a dialog window is loaded. 
				onShow : function()
				{
					// Get the element selected in the editor.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#getSelection
					var sel = editor.getSelection(),
					// Assigning the element in which the selection starts to a variable.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.selection.html#getStartElement
						element = sel.getStartElement();
					
					// Get the <acronym> element closest to the selection.
					if ( element )
						element = element.getAscendant( 'acronym', true );
					
					// Create a new <acronym> element if it does not exist.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.document.html#createElement
					// For a new <acronym> element set the insertMode flag to true.
					if ( !element || element.getName() != 'acronym' || element.data( 'cke-realelement' ) )
					{
						element = editor.document.createElement( 'acronym' );
						this.insertMode = true;
					}
					// If an <acronym> element already exists, set the insertMode flag to false.
					else
						this.insertMode = false;
					
					// Store the reference to the <acronym> element in a variable.
					this.element = element;
					
					// Invoke the setup functions of the element.
					this.setupContent( this.element );
				},				
				// This method is invoked once a user closes the dialog window, accepting the changes.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.dialogDefinition.html#onOk
				onOk : function()
				{
					// A dialog window object.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.html 
					var dialog = this,
						acronym = this.element;
					
					// If we are not editing an existing acronymeviation element, insert a new one.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#insertElement
					if ( this.insertMode )
						editor.insertElement( acronym );
					
					// Populate the element with values entered by the user (invoke commit functions).
					this.commitContent( acronym );
				}
			};
		} );
	}
} );
