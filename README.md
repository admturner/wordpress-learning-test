# Working Draft of Presentation Notes

By Adam Turner

### Intro

In general: an overview of dynamic website content management systems (CMS), using WordPress as an example.

The goal here is to get an idea of what WordPress can (and maybe also can't) do, and to think in terms of content creation -- For most of us, the website (or application or program) isn't the content, it's part of the delivery.

  * What I like about WP and other applications like it: add flexibility and can be as simple or as complicated as you want.
  * Allow you to add functionality without modifying the WP core, so that you can jump between themes and upgrade without (as much) concern about things breaking
  * If you break something, you can just disable the plugin

At it's most basic, WordPress is a program that generates web pages on the fly.

### Static vs. Dynamic sites

  * *Use Hello World post as example, with hello-world-page.html*

"Static" or "Dynamic" refers to the process of building the page
  
  * Static: Complete HTML file for computer to read (+ JS + CSS)
  * Dynamic: Server builds HTML file on the fly
      - How PHP becomes HTML
          + Database (MySQL) with Script (PHP)

  In both cases, the end HTML file may look the same, but it was created in different ways

### The WordPress (and sort of Drupal and Omeka) way

  * Built on PHP, but when working with it you're really working with preexisting WordPress functions than with core PHP.
  
  * Templates - The Core functionality
      - *Draw this on the board*:
        + Each page is made up of multiple templates, which assemble completed HTML documents by executing PHP functions and "including" content
        + Walk through the "Hello World" post example
          * You write the post in the Admin area
          * It gets saved to the database in tables
          * When requested, WP asks for the correct Template (single.php) and follows the PHP script there to generate a single HMTL document
          * It then serves that HTML document to your browser
        
      - Walk through header.php + single.php (etc.) + footer.php
  
    * Where does a WordPress webpage live?
      - Nowhere. Everywhere.
      - Parts stored in different places:
          + Database tables (often multiple)
          + PHP functions (methods)
          + PHP templates (like views)
              * Show each of these: phpMyAdmin to show the actual content of a post in its database, and what the same query looks like on the live site
              * Post template (single.php) to show how it is "called"

### WordPress Plugins

  * Used to extend the standard functionality of the CMS
  
  * *Show in the WP Admin area*

### Basic plugin creation

  * *Walk through creating the DSC Learning Plugin*

  * Heading
  * Functions
  * Spell out what we want it to do
    - *Be sure to view user list in Admin area*
    - Go step-by-step
    - Test as you go

### Implementing our functions

  * Template tags
      - Shortcodes

  * Action and Filter hooks