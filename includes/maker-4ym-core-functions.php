<?php
/**
* The maker-4ym core functions.
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

/*
* Move story through from admin columns
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

add_filter( 'manage_story_posts_columns', 'maker_4ym_tutorial_column_order', 20 );

function maker_4ym_tutorial_column_order($columns) {
    $n_columns = array();
    $move = 'title'; // what to move
    $before = 'story_image'; // move before this

    foreach( $columns as $key=>$value ) {
        if ( $key == $before ) {
            $n_columns[$move] = $move;
        }
            $n_columns[$key] = $value;
    }
    return $n_columns;
}

/*
* Change admin menu posts label
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

function maker_4ym_menu_posts_label() {
    global $menu;
    global $submenu;

    $menu[5][0] = 'Blog 4YM';
    $submenu['edit.php'][5][0] = 'Artículos del Blog';
    $submenu['edit.php'][10][0] = 'Agregar un Nuevo Artículo'; 
}
add_action( 'admin_menu', 'maker_4ym_menu_posts_label' );

/*
* Change post object label
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

function maker_4ym_change_post_object_label() {
    global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Blog';
    $labels->singular_name = 'Artículos del Blog';
    $labels->add_new = 'Agregar un nuevo artículo';
    $labels->add_new_item = 'Escribir un nuevo artículo';
    $labels->edit_item = 'Editar un artículo';
    $labels->new_item = 'Nuevo artículo';
    $labels->view_item = 'Ver artículo';
    $labels->search_items = 'Buscar artículos';
    $labels->not_found = 'ningún artículo coincide con tu búsqueda';
    $labels->not_found_in_trash = 'ningún artículo en la papelera coincide con la búsqueda';
}

add_action( 'admin_menu', 'maker_4ym_change_post_object_label' );

/*
* Change menu order
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

function maker_4ym_change_menu_order() {
    return array(
        'index.php',
        'edit.php',
        'edit.php?post_type=story',
	'upload.php'
    );
}
add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'maker_4ym_change_menu_order' );

/*
* Remove tags from posts listing screen
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

function maker_4ym_remove_posts_listing_tags( $columns ) {
    unset( $columns[ 'comments' ] );
    unset( $columns[ 'date' ] );
    return $columns;
}
add_action( 'manage_story_posts_columns', 'maker_4ym_remove_posts_listing_tags' , 20 );

/*
* Remove unwanted dashboard widgets for relevant users
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

function maker_4ym_remove_dashboard_widgets() {
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'maker_4ym_remove_dashboard_widgets' );

/*
* Move the 'Right Now' dashboard widget to the right hand side
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

function maker_4ym_move_dashboard_widget() {
    global $wp_meta_boxes;
    $widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'];
    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
    $wp_meta_boxes['dashboard']['side']['core']['dashboard_activity'] = $widget;
}
add_action( 'wp_dashboard_setup', 'maker_4ym_move_dashboard_widget' );

/*
* Add new dashboard widgets
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

function maker_4ym_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'maker_4ym_dashboard_welcome', '¡Bienvenido!', 'maker_4ym_add_welcome_widget' );
    wp_add_dashboard_widget( 'maker_4ym_dashboard_links', 'Enlaces de interés', 'maker_4ym_add_links_widget' );
}

function maker_4ym_add_welcome_widget(){?>
 
    4youmaker es un sitio para compartir, buscar y coleccionar tutoriales.
 
    Puedes usar estas herramientas a través de la barra de usuario que está siempre a tu zquierda, haciendo click en el ícono. 
    <br>
    <?php
        echo '<div class="row-images"><div class="nav-example"><img src="' . esc_url( plugins_url( 'images/navegacion.png', __FILE__ ) ) . '" /></div>'; 
        echo '<div class="nav-example"><img src="' . esc_url( plugins_url( 'images/compartir.png', __FILE__ ) ) . '" /></div></div>'; 
    ?>
 
    <ul>
        <li><strong>Compartir tutoriales</strong> - copiando y pegando la URL del tutorial que quieras compartir.</li>
        <li><strong>Coleccionar tutoriales</strong> - tus tutoriales preferidos se guardan automáticamente en Mis Favoritos con tan solo hacer click en "Me Gusta".</li>
        <li><strong>Busca un tutorial</strong> - en la barra de navegación superior puedes buscar el tutorial que necesitas.</li>
    </ul>
 
    También puedes revisar tu perfil de <strong>Maker</strong> haciendo click en Mis Tutoriales. <?php

}
 
function maker_4ym_add_links_widget() { ?>
 
    Algunos enlaces que te pueden ayudar a desarrollar tu perfil de <strong>Maker</strong>:
 
    <ul>
	<li><strong id="current">Hola</strong></li>
        <li><a href="<?php esc_url( 'https://4youmaker.com/perfil/', 'maker-4ym' ); ?>">Mi Perfil</a></li>
        <li><a href="<?php esc_url( 'https://4youmaker.com/blog/', 'maker-4ym' ); ?>">Nuestro Blog</a></li>
        <li><a href="<?php esc_url( 'https://4youmaker.com/mis-tutoriales/', 'maker-4ym' ); ?>">Mis Tutoriales</a></li>
    </ul>
<?php }
add_action( 'wp_dashboard_setup', 'maker_4ym_add_dashboard_widgets' );

/*
* Enqueuing admin styles
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/
function maker_4ym_admin_styles() {
    wp_register_style( 'maker_4ym_admin_stylesheet', plugins_url( '/css/style.css',__FILE__ ) );
    wp_enqueue_style( 'maker_4ym_admin_stylesheet' );
}

add_action( 'admin_enqueue_scripts', 'maker_4ym_admin_styles' );


 
/*
* Footer text
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/
function maker_4ym_admin_footer_text() {
  echo '<img src="' . esc_url( plugins_url( 'images/4youmakerlogo.png', __FILE__ ) ) . '"> Busca, colecciona o comparte un <a href="'. esc_url( 'https://4youmaker.com', 'maker-4ym' ) . '">tutorial</a>.';
}

add_filter( 'admin_footer_text', 'maker_4ym_admin_footer_text');



	
						



	
	




