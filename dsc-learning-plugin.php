<?php
/**
 * Plugin Name: DSC Plugin Learning
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
 * built based on WordPress' native wp_list_users function,
 * but this returns more user info and uses the built in "role" 
 * parameter for the get_users() WordPress wrapper function
 * instead of a manual "exclude admin" setting. Roles should
 * be specified as: Admins = 'administrator'; Editors = 'editor';
 * Authors = 'author'; Contributors = 'contributor'; Subscribers =
 * 'subscriber'. Bio length is in words, and if you want the whole
 * bio (user description field) then enter 9999.
 *
 * @todo Needs a `usage` description field here
 * @uses get_users();
 * @uses wp_trim_words();
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
      'show_fullname' => true,
      'show_grammtitle' => true,
      'social_links' => true,
      'biolength' => 55,
      'avatarsize' => 90,
      'layout' => '',
      'heading_tag' => 'h3',
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

    // Show full name by default, but has option for display name instead, and defaults there if first or last is empty
    if ( $args['show_fullname'] && $author->first_name && $author->last_name ) {
      $name = "$author->first_name $author->last_name";
    } else {
      $name = $author->display_name;
    }

    // If the user has a bio save it, otherwise overwrite the previous one in the loop with null
    if ( get_the_author_meta( 'description', $author->ID ) ) {
      $bio = get_the_author_meta( 'description', $author->ID );
    } else {
      $bio = '';
    }
    
    // If the user has Nursing Clio title filled in, otherwise set it to Contributor as default
    // TODO Remove nctitle functionality to external plugin
    if ( $args['show_grammtitle'] ) {
      if ( get_the_author_meta( 'grammtitle', $author->ID ) ) {
        $nctitle = '<p class="nc-title">' . get_the_author_meta( 'grammtitle', $author->ID ) . '</p>';
      } else {
        $nctitle = '<p class="nc-title">Contributor</p>';
      }
    } else {
      $nctitle = '';
    }

    // If user has Twitter field filled in prep it, otherwise reset
    if ( $args['social_links'] && get_the_author_meta( 'twitter', $author->ID ) ) {
      $twit = '<p class="social-links"><a class="twitter" href="https://twitter.com/' . get_the_author_meta( 'twitter', $author->ID ) . '" title="' . esc_attr( sprintf(__("%s on Twitter"), $author->display_name) ) . '">@' . get_the_author_meta( 'twitter', $author->ID ) . '</a></p>';
    } else {
      $twit = '';
    }

    $authorlink = '<a class="fn" href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '">' . $name . '</a>';

    // BUILD output

    $return .= '<section id="author-id-' . $author->ID . '" class="author ' . $args['layout'] . ' vcard">';
      if ( $args['avatarsize'] > 0 ) {
        // Do if avatarsize is greater than 0
        $return .= '<div class="avatar-wrap avatar-size-' . $args['avatarsize'] . 'px">';
        $return .= get_avatar( $author->ID, $args['avatarsize'] );
        $return .= '</div>';
      }

      $return .= '<div class="bio-wrap">';
      $return .= '<' . $args['heading_tag'] . '>' . $authorlink . '</' . $args['heading_tag'] . '>';
      $return .= $nctitle;
      $return .= $twit;
      
      if ( $args['biolength'] > 0 && $bio ) {
        $return .= '<p class="author-bio">';
        // Trim if desired
        if ( $args['biolength'] < 9995 ) {
          $authrole = get_the_author_meta( 'roles', $author->ID );
          if ( in_array('contributor', $authrole) ) {
            $morelink = get_author_posts_url( $author->ID, $author->user_nicename );
          } else {
            $morelink = esc_url( get_site_url() . '/about/meet-the-team/#author-id-' . $author->ID );
          }

          $more = '&hellip; <a href="' . $morelink . '" title="' . esc_attr( 'Read ' . $author->display_name . '&rsquo;s full bio' ) . '">' . ( !empty($author->first_name) ? $author->first_name : $author->display_name) . '&rsquo;s full bio &rarr;</a>';
          $bio = wp_trim_words( $bio, $args['biolength'], $more );
        }
        $return .= wptexturize( $bio );
        $return .= '</p>';
      }

      $return .= '</div>';
    $return .= '</section>'; // End output
  } /* End foreach loop */

  if ( ! $args['echo'] ) {
    return $return;
  }

  // OUTPUT results

  echo $return;
}


/* === A LITTLE ABOUT WP HOOKS === */

/**
 * Add content to HTML head
 * 
 * Hook into wp_head() to insert content into the hearder
 * of all generated HTML pages on the non-admin site.
 *
 * @uses wp_head()
 * @since 0.1
 */
function dsc_add_header_junk() {
	// content here
}
add_action('wp_head', 'dsc_add_header_junk', 15);


/* End of file */