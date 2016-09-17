<?php
/*
Plugin Name: KP's Books CPT
Description: KP's plugin for keeping a list of books
Text Domain: kp
*/

add_action( 'init', 'create_posttype' );
function create_posttype() {
  register_post_type( 'kp_books',
    array(
      'labels' => array(
        'name' => __( 'Books', 'kp' ),
        'singular_name' => __( 'Books', 'kp' ),
        'add_new' => __( 'Add New', 'kp' ),
    	'add_new_item' => __( 'Add New Book', 'kp' ),
    	'edit_item' => __( 'Edit Book', 'kp' ),
    	'new_item' => __( 'New Book', 'kp' ),
    	'all_items' => __( 'All Books', 'kp' ),
    	'view_item' => __( 'View Book', 'kp' ),
    	'search_items' => __( 'Search Books', 'kp' ),
    	'not_found' => __( 'No Books found', 'kp' ),
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array( 'slug' => 'books' ),
    )
  );
   $books_author_labels = array(
    'name' => __( 'Author', 'kp' ),
    'singular_name' => __( 'Author', 'kp' ),
    'search_items' => __( 'Search Authors', 'kp' ),
    'all_items' => __( 'All Authors', 'kp' ),
    'edit_item' => __( 'Edit Author', 'kp' ),
    'update_item' => __( 'Update Author', 'kp' ),
    'add_new_item' => __( 'Add New Author', 'kp' ),
    'new_item_name' => __( 'New Author Name', 'kp' ),
    'menu_name' => __( 'Authors', 'kp' ),
  );
  $books_author_args = array(
    'hierarchical' => true,
    'labels' => $books_author_labels,
    'show_ui' => true,
    'show_admin_column' => true,
  );
  $books_genre_labels = array(
    'name' => __( 'Genre', 'kp' ),
    'singular_name' => __( 'Genre', 'kp' ),
    'search_items' => __( 'Search Genres', 'kp' ),
    'all_items' => __( 'All Genres', 'kp' ),
    'edit_item' => __( 'Edit Genre', 'kp' ),
    'update_item' => __( 'Update Genre', 'kp' ),
    'add_new_item' => __( 'Add New Genre', 'kp' ),
    'new_item_name' => __( 'New Genre Name', 'kp' ),
    'menu_name' => __( 'Genres', 'kp' ),
  );
  $books_genre_args = array(
    'hierarchical' => true,
    'labels' => $books_genre_labels,
    'show_ui' => true,
    'show_admin_column' => true,
  );
  
  register_taxonomy( 'books-author', array( 'kp_books' ), $books_author_args );
  register_taxonomy( 'books-genre', array( 'kp_books' ), $books_genre_args ); 
}


add_filter( 'the_content', 'custom_taxonomies_content' ); 
 
 function custom_taxonomies_content( $content ) { 
 	global $post;
 	
    if ( in_the_loop() && is_post_type_archive( 'kp_books' ) ) { 
		$authors = get_the_term_list( $post->ID, 'books-author', '<li class="book-author">Authors: ', ', ', '</li>' );
        
    	$genres = get_the_term_list( $post->ID, 'books-genre', '<li class="book-genre">Genre: ', ', ', '</li>' );
        
        $content = "<ul class=\"book-tags\">" . the_date('Y', '<li>Published: ', '</li>') . $authors . $genres . "</ul>" . $content;        
	}

    return $content;
}