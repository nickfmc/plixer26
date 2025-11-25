<?php
/**
 * GutenDev Custom Post Type Registration Party
 * REMBEMBER -> Uncomment / add this file to functions.php
 */

// register ###Lower CTA### custom post type
add_action( 'init', 'gdt_lowercta_reg' );

// create a custom post type and name it
function gdt_lowercta_reg() {
  $singular = 'Lower CTA';
  $plural = 'Lower CTAs';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => true,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 21,
    'menu_icon'            => 'dashicons-admin-page',
    'rewrite'              => false, // or: array( 'slug' => 'custom_type_url/list', 'with_front' => false ),
    'capability_type'      => 'post',
    'has_archive'          => false, // true or use custom slug: 'custom_type_url/past' */
    'hierarchical'         => false,
    'supports'             => array( 'title', 'thumbnail', 'revisions' )
  );
  register_post_type( 'cta_type', $args );
}


// register ###Lower CTA### custom post type
add_action( 'init', 'gdt_news_reg' );

// create a custom post type and name it
function gdt_news_reg() {
  $singular = 'News Item';
  $plural = 'News Items';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => false,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 21,
    'menu_icon'            => 'dashicons-book',
    'rewrite'              =>  array( 'slug' => 'news', 'with_front' => false ),
    'capability_type'      => 'post',
    'has_archive'          => false, // true or use custom slug: 'custom_type_url/past' */
    'hierarchical'         => false,
    'supports'             => array( 'title', 'thumbnail', 'editor', 'revisions' , 'excerpt' )
  );
  register_post_type( 'news_type', $args );
}


// register career type
add_action( 'init', 'gdt_career_reg' );

// create a custom post type and name it
function gdt_career_reg() {
  $singular = 'Job Posting';
  $plural = 'Job Postings';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => true,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 21,
    'menu_icon'            => 'dashicons-businessman',
    'rewrite'              =>  array( 'slug' => 'careers', 'with_front' => false ),
    'capability_type'      => 'post',
    'has_archive'          => false, // true or use custom slug: 'custom_type_url/past' */
    'hierarchical'         => false,
    'supports'             => array( 'title','revisions', 'excerpt' )
  );
  register_post_type( 'career_type', $args );

}


// register career type
add_action( 'init', 'gdt_author_reg' );

// create a custom post type and name it
function gdt_author_reg() {
  $singular = 'Post Author';
  $plural = 'Post Authors';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => true,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 21,
    'menu_icon'            => 'dashicons-businessman',
    'rewrite'              =>  false,
    'capability_type'      => 'post',
    'has_archive'          => false, // true or use custom slug: 'custom_type_url/past' */
    'hierarchical'         => false,
    'supports'             => array( 'title')
  );
 
  register_post_type( 'postauthor_type', $args );
}


// register member blog type
add_action( 'init', 'gdt_member_blog_reg' );

// create member blog type
function gdt_member_blog_reg() {
  $singular = 'Member Blog Post';
  $plural = 'Member Blog Posts';
  $labels = array(
    'name'                 => "$plural",
    'singular_name'        => "$singular",
    'menu_name'            => "$plural",
    'name_admin_bar'       => "$singular",
    'add_new'              => 'Add New',
    'add_new_item'         => "Add New $singular",
    'new_item'             => "New $singular",
    'edit_item'            => "Edit $singular",
    'view_item'            => "View $singular",
    'all_items'            => "All $plural",
    'search_items'         => "Search $plural",
    'parent_item_colon'    => "Parent $plural:",
    'not_found'            => "No $plural Found",
    'not_found_in_trash'   => "No $plural Found in Trash",
  );
  $args = array(
    'labels'               => $labels,
    'public'               => true,
    'show_in_rest'         => true,
    'publicly_queryable'   => true,
    'exclude_from_search'  => true,
    'show_ui'              => true,
    'show_in_menu'         => true,
    'query_var'            => true,
    'menu_position'        => 21,
    'menu_icon'            => 'dashicons-edit-page',
    'rewrite'              => array( 'slug' => 'member-blog', 'with_front' => false ),
    'capability_type'      => 'post',
    'has_archive'          => true,
    'hierarchical'         => false,
    'supports'             => array( 'title', 'thumbnail', 'editor', 'revisions', 'excerpt', 'author', 'comments' )
  );
  register_post_type( 'member_blog_type', $args );
}

?>
