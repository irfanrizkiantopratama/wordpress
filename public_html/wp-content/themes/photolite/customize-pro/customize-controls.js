( function( api ) {

	// Extends our custom "photolite" section.
	api.sectionConstructor['photolite'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );