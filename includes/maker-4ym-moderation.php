<?php
/**
* Functions for moderation
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

/*
 * Nuevas columnas
 */
add_filter( 'manage_story_posts_columns', 'maker_4ym_price_and_featured_columns');

function maker_4ym_price_and_featured_columns( $columns_array ) {

    $columns_array['tut_url'] = 'URL del tutorial';
    $columns_array['featured'] = 'Tutorial patrocinado';

    return $columns_array;
}

/*
 * Populate our new columns
 */
add_action( 'manage_posts_custom_column', 'maker_4ym_populate_both_columns',10, 2 );
function maker_4ym_populate_both_columns( $column_name, $id ) {
    
    switch( $column_name ) :
        case 'tut_url' : {
            echo get_post_meta( $id, '_story_url', true );
            break;
        }
        case 'featured' : {
	    if( get_post_meta( $id, 'product_featured', true ) == 'on' )
		echo 'Sí';
	    break;
        }
    endswitch;
    
}

/*
 *  Wrap field in proper HTML
 */
add_action('quick_edit_custom_box', 'maker_4ym_quick_edit_fields', 10, 2 );

function maker_4ym_quick_edit_fields( $column_name, $post_type ) {
    
    switch( $column_name ) : 

        case 'tut_url' : {
            wp_nonce_field('maker4ym_q_edit_nonce', 'maker4ym_nonce');

	    echo '<fieldset class="inline-edit-col-right">
		    <div class="inline-edit-col">
		      <div class="inline-edit-group wp-clearfix">';
	    echo '<label class="alignleft">
		    <span class="title">URL del Tutorial</span>
		    <span class="input-text-wrap"><input type="text" name="tut_url" value=""></span>
	          </label>';
	break;
    }
        case 'featured' : {
            
	     echo '<label class="alignleft">
	             <input type="checkbox" name="featured">
		     <span class="checbox-title">Tutorial patrocinado</span>
	           </label>';

             echo '</div></div></fieldset>';

	break;

    }

    endswitch;

}

/*
 * Quick edit save
 */
add_action( 'save_post', 'maker_4ym_quick_edit_save' );

function maker_4ym_quick_edit_save( $post_id ) {
    
    if ( !current_user_can( 'edit_post', $post_id ) ) {

        return;

    }
   
    if ( !wp_verify_nonce( $_POST['maker4ym_nonce'], 'maker4ym_q_edit_nonce' ) ) {

        return;

    }
    
    if ( isset( $_POST['tut_url'] ) ) {

        update_post_meta( $post_id, '_story_url', $_POST['tut_url'] );

    }

    if ( isset( $_POST['featured']) ) {

        update_post_meta( $post_id, 'product_featured', 'on' );

    } else {

        update_post_meta( $post_id, 'product_featured', '' );

    }

}

add_action( 'admin_enqueue_scripts', 'maker_4ym_enqueue_quick_edit_population' );

function maker_4ym_enqueue_quick_edit_population( $pagehook ) {
  
    if ( 'edit.php' != $pagehook ) {

        return;

    }

    wp_enqueue_script( 'populatequickedit', plugins_url( '/js/populate.js',__FILE__ ) , array( 'jquery' ), '1.0', true);

}

/*
 *  Bulk Edit Fields
 */ 

add_action( 'bulk_edit_custom_box','maker_4ym_quick_edit_fields', 10, 2);

add_action( 'wp_ajax_maker_4ym_save_bulk', 'maker_4ym_save_bulk_edit_hook' );

function maker_4ym_save_bulk_edit_hook() {
    
    if ( !wp_verify_nonce( $_POST['nonce'], 'maker4ym_q_edit_nonce' ) ) {

        die();

    }

    if ( empty( $_POST[ 'post_ids' ] ) ) {

        die();

    }
    
    foreach( $_POST[ 'post_ids' ] as $id ) {
        
        if ( !empty( $_POST[ 'tut_url' ] ) ) {

            update_post_meta( $id, '_story_url', $_POST['tut_url'] );

        }

	if ( !empty( $_POST[ 'featured' ] ) ) {

	    update_post_meta( $id, 'product_featured', 'on' );

	} else {

	    update_post_meta( $id, 'product_featured', '' );

	}

    }

    die();
}

/*
 *  @Snippet: Custom bulk action Publicar Tutorial
 */

//Hooks
add_action( 'current_screen', 'maker_4ym_bulk_hooks' );
function maker_4ym_bulk_hooks() {
    if( current_user_can( 'administrator' ) ) {
      add_filter( 'bulk_actions-edit-story', 'register_maker_4ym_bulk_actions' );
      add_filter( 'handle_bulk_actions-edit-story', 'maker_4ym_bulk_action_handler', 10, 3 );
      add_action( 'admin_notices', 'maker_4ym_bulk_action_admin_notice' );      
    }
}   

//Register
function register_maker_4ym_bulk_actions($bulk_actions) {
  $bulk_actions['bulk_moderation'] = __( 'Publicar tutorial', 'upvote-child');
  return $bulk_actions;
}

//Handle 
function maker_4ym_bulk_action_handler( $redirect_to, $doaction, $post_ids ) {
  if ( $doaction !== 'bulk_moderation' ) {
    return $redirect_to;
  }
  foreach ( $post_ids as $post_id ) {
    // Perform action for each post.
    global $wpdb;
    $query = array(
        'post_type' => 'story',
        'post_status' => 'draft',
	);

    $query = "UPDATE ".$wpdb->prefix."posts SET post_status='publish' WHERE ID = '".$post_id."'";
    $wpdb->query($query);
  }

  $redirect_to = add_query_arg( 'bulk_moderated_posts', count( $post_ids ), $redirect_to );
    return $redirect_to;
}

//Notices
function maker_4ym_bulk_action_admin_notice() {
  if ( ! empty( $_REQUEST['bulk_moderated_posts'] ) ) {
    $tut_count = intval( $_REQUEST['bulk_moderated_posts'] );
    printf( '<div id="message" class="updated fade">' .
      _n( '%s tutorial publicado.',
        '%s tutoriales publicados.',
        $tut_count,
        'maker-4ym'
      ) . '</div>', $tut_count );
  }
}





