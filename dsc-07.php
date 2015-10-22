<?php
/**
 * Plugin Name: DSC Building 7
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
      'heading_tag' => 'h5',
      'echo' => true
  );
  $args = wp_parse_args( $args, $defaults );

  $return = '';

  // GET data from database with database query

  // Use this to get the paramenters we need for get_users() out of the default $args
  $query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'role', 'include' ) );
  // Used to request only an array of user IDs from get_users()
  $query_args['fields'] = 'ids';
  $authors = get_users( $query_args );

  // STEP through the data

  foreach ( $authors as $authorid ) {
    
    // GET individual user data and save in temporary variables

    $author = get_userdata( $authorid );

      // First Last name
      if ( $author->first_name && $author->last_name ) {
        $name = "$author->first_name $author->last_name";
      } else {
        $name = $author->display_name;
      }

      // Bio
      if ( get_the_author_meta( 'description', $author->ID ) ) {
        $bio = get_the_author_meta( 'description', $author->ID );
      } else {
        $bio = '';
      }

      // Twitter handle
      if ( get_the_author_meta( 'twitter', $author->ID ) ) {
        $twit = '<p class="social-links"><a class="twitter" href="https://twitter.com/' . get_the_author_meta( 'twitter', $author->ID ) . '" title="' . esc_attr( sprintf(__("%s on Twitter"), $author->display_name) ) . '">@' . get_the_author_meta( 'twitter', $author->ID ) . '</a></p>';
      } else {
        $twit = '';
      }
      // Link to users's posts
      $authorlink = '<a class="fn" href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '">' . $name . '</a>';

    // BUILD output

    $return .= '<section class="author byline vcard">';

      // Image
      $return .= '<div class="avatar-wrap avatar-size-90">';
        $return .= get_avatar( $author->ID, 90 );
      $return .= '</div>';

      $return .= '<div class="bio-wrap">';
      
      $return .= '<' . $args['heading_tag'] . '>' . $authorlink . '</' . $args['heading_tag'] . '>';
      $return .= $twit;
      
      if ( $args['biolength'] > 0 && $bio ) {
        $return .= '<p class="author-bio">';
          $return .= wptexturize( $bio );
        $return .= '</p>';
      }

      $return .= '</div><!-- close .bio-wrap -->';

    $return .= '</section>'; // End output

  } // End foreach loop

  // OUTPUT results
  // guesses?
}

/* End of file */