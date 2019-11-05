jQuery(function(jQuery) {
    var wp_inline_edit_function = inlineEditPost.edit;
    
    inlineEditPost.edit = function( post_id ) {
    
        wp_inline_edit_function.apply( this, arguments );
        
        var id = 0;
        
        if ( typeof( post_id ) == 'object' ) {

	    id = parseInt( this.getId( post_id ) );

        }

        if ( id > 0 ) {
        
            var specific_post_edit_row = jQuery( '#edit-' + id ),
                specific_post_row = jQuery( '#post-' + id),
                story_url = jQuery( '.column-tut_url', specific_post_row ).text(),
                featured_product = false;
            if( jQuery( '.column-featured', specific_post_row ).text() == 'Yes' ) featured_product = true;

            jQuery( ':input[name="tut_url"]', specific_post_edit_row ).val( story_url );
            jQuery( ':input[name="featured"]', specific_post_edit_row ).prop('checked', featured_product );

        }

    } 

    jQuery( 'body' ).on( 'click', 'input[name="bulk_edit"]', function() {
	   
		   jQuery( this ).after('<span class="spinner is-active"></span>');
		   var bulk_edit_row = jQuery( 'tr#bulk-edit' ),
		       post_ids = new Array(),
		       tut_url = bulk_edit_row.find( 'input[name="tut_url"]').val(),
		       featured = bulk_edit_row.find( 'input[name="featured"]' ).attr( 'checked' ) ? 1 : 0;

		   bulk_edit_row.find( '#bulk-titles' ).children().each( function() {
		       post_ids.push( jQuery( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
		   });

		   jQuery.ajax({
			       url: ajaxurl,
			       type: 'POST',
			       async: false,
			       cache: false,
			       data: {
				      action: 'maker_4ym_save_bulk',
				      post_ids: post_ids,
				      tut_url: tut_url,
				      featured: featured,
				      nonce: jQuery( '#maker4ym_nonce' ).val()
			       }
		    });
	    });

});



