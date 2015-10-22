<?php
/**
 * Plugin Name: DSC Building 2
 * Plugin URI: https://github.com/admturner/
 * Description: A plugin for learning about plugins.
 * Author: Adam Turner
 * Author URI: http://adamturner.org
 * Version: 0.1
 *
 * @package WordPress
 * @version 0.1
 * @author  Adam Turner
 * @copyright Copyright (c) 2015, Adam Turner, GPL 2.0+
 * @license http://www.gnu.org/licenses/gpl.html
 * @link https://github.com/admturner/
 */

/**
 * Custom List Users
 * 
 * Custom function to generate a list of blog authors,
 * built based on WordPress' native wp_list_users function.
 *
 * @since Grammatizator 0.6
 */
function gramm_list_authors( $args = '' ) {
  
  // SET up variables
  global $wpdb;

  $defaults = array(
      'orderby' => 'name',
      'order' => 'ASC',
      'role' => '',
      'include' => array(),
      'biolength' => 55,
      'heading_tag' => 'h3',
      'echo' => true
  );
  $args = wp_parse_args( $args, $defaults );

  $return = '';

  /* Test me */
  print_r($args);


  // GET data from database with database query

  // STEP through the data
    
    // GET individual user data and save in temporary variables

      // First Last name
      // Bio
      // Twitter handle
      // Link to users's posts
      // Image (get later)

    // BUILD output

  // OUTPUT results
}


/* End of file */