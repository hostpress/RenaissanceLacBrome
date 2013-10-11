<?php
/**
 * WARNING: This file is part of the core Genesis framework. DO NOT edit
 * this file under any circumstances. Please do all modifications
 * in the form of a child theme.
 *
 * Handles the header structure.
 *
 * @package Genesis
 */
do_action( 'genesis_doctype' );
do_action( 'genesis_title' );
do_action( 'genesis_meta' );

wp_head(); /** we need this for plugins **/
?>
<?php if (is_page('Documentation')) { ?>
<style type="text/css">
#sidebar {
    color: #1B1003;
    display: inline;
    float: right;
    margin: 0;
    padding: 5px 0 0;
    width: 185px;
}
</style>
<?php }; ?>
</head>
<body <?php body_class(); ?>>
<?php
do_action( 'genesis_before' );

?>
<div id="wrap">
<div id="top-menu">
<?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'fallback_cb' => ' ' ) ); ?><span id="language-switcher">
<?php do_action('language_header');
?>
 </span><div id="font-resizer-ticker"></div></div><?php
do_action( 'genesis_before_header' );
do_action( 'genesis_header' );
do_action( 'genesis_after_header' );

echo '<div id="inner">';
genesis_structural_wrap( 'inner' );