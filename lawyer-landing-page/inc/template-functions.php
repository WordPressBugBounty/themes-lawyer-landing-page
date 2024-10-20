<?php
/**
 * Custom template functions for this theme.
 *
 * @package Lawyer_Landing_Page
*/

if( ! function_exists( 'lawyer_landing_page_doctype_cb' ) ) :
/**
 * Doctype Declaration
*/
function lawyer_landing_page_doctype_cb(){
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'lawyer_landing_page_doctype', 'lawyer_landing_page_doctype_cb' );

if( ! function_exists( 'lawyer_landing_page_head' ) ) :
/**
 * Before wp_head 
*/
function lawyer_landing_page_head(){
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
}
endif;
add_action( 'lawyer_landing_page_before_wp_head', 'lawyer_landing_page_head' );

if( ! function_exists( 'lawyer_landing_page_page_start' ) ) :
/**
 * Page Start
*/
function lawyer_landing_page_page_start(){
    ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'lawyer-landing-page' ); ?></a>
    <?php
}
endif;
add_action( 'lawyer_landing_page_before_header', 'lawyer_landing_page_page_start', 20 );

if( ! function_exists( 'lawyer_landing_page_header_start' ) ) :
/**
 * Header Start
*/
function lawyer_landing_page_header_start(){
    ?>
    <header id="masthead" class="site-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
        <div class="container">
    <?php 
}
endif;
add_action( 'lawyer_landing_page_header', 'lawyer_landing_page_header_start', 20 );

if( ! function_exists( 'lawyer_landing_page_header_top' ) ) :
/**
 * Header Top
*/
function lawyer_landing_page_header_top(){
    
    $phone     = get_theme_mod( 'phone' ); // from customizer
    $ed_social = get_theme_mod( 'ed_social' );
    ?>
    
    <div class="header-t">
        <div class="site-branding" itemscope itemtype="https://schema.org/Organization">
            <?php 
		        if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    the_custom_logo();
                } 
            ?>
			<div class="text-logo">
                <?php if ( is_front_page() ) : ?>
                    <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                <?php endif;
    			$description = get_bloginfo( 'description', 'display' );
    			if ( $description || is_customize_preview() ) : ?>
    				<p class="site-description" itemprop="description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
    			<?php
    			endif; ?>
            </div>
        </div><!-- .site-branding -->
		  
		<div class="tools">
            <?php
                if( $ed_social ) lawyer_landing_page_get_social_links(); //Social links
                if( $phone ) echo '<a href="' . esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ) . '" class="tel-link">' . esc_html( $phone ) . '</a>';
			?>
		</div>
    </div>
    <?php
}
endif;
add_action( 'lawyer_landing_page_header', 'lawyer_landing_page_header_top', 30 );

if( ! function_exists( 'lawyer_landing_page_header_bottom' ) ) :
/**
 * Header Bottom
*/
function lawyer_landing_page_header_bottom(){
    
    $ed_search_form = get_theme_mod( 'ed_search', '1' );
    ?>
    <div class="header-b">
        <button class="menu-opener" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="mobile-menu-wrapper">
            <nav id="mobile-site-navigation" class="main-navigation mobile-navigation">        
                <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                    <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"></button>
                    <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'lawyer-landing-page' ); ?>">
                        <?php
                            wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'menu_id'        => 'mobile-primary-menu',
                                'menu_class'     => 'nav-menu main-menu-modal',
                            ) );
                        ?>
                    </div>
                </div>
            </nav><!-- #mobile-site-navigation -->
        </div>
        
		<nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
        </nav>
		<?php if( $ed_search_form ) get_search_form(); ?>
    </div>
    <?php
}
endif;
add_action( 'lawyer_landing_page_header', 'lawyer_landing_page_header_bottom', 40 );

if( ! function_exists( 'lawyer_landing_page_header_end' ) ) :
/**
 * Header End
*/
function lawyer_landing_page_header_end(){
    ?>
        </div>
    </header>
    <?php
}
endif;
add_action( 'lawyer_landing_page_header', 'lawyer_landing_page_header_end', 100 );

if( ! function_exists( 'lawyer_landing_page_pg_header' ) ) :
/**
 * Page Header for inner pages
*/
function lawyer_landing_page_pg_header(){    
    if( ! is_front_page() && ! is_page_template( 'template-home.php' ) ){
        
        $class = is_page() ? 'entry-header' : 'page-header' ;
        $ed_bc = get_theme_mod( 'ed_breadcrumb' ); //from customizer
    
        if( is_single() ){ 
            if( $ed_bc ){ ?>
            
            <div class="top-bar">
        		<div class="container">
                    <?php lawyer_landing_page_breadcrumb(); // breadcrumb ?>
                </div>
            </div>
            
        <?php   
            }
        }else{
            ?>
            <!-- Page Header for inner pages only -->
            <div class="top-bar">
        		<div class="container">
                    <header class="<?php echo esc_attr( $class ); ?>">
                        <h1 class="page-title">
                        <?php                
                        
                            if( is_home() ) single_post_title();
                            
                            if( is_page() ) the_title(); //For Page, Post & Attachment
                            
                            if( is_search() ) printf( esc_html__( 'Search Results for "%s"', 'lawyer-landing-page' ), get_search_query() ); 
                            
                            if( is_404() ) echo esc_html__( '404 - Page not Found', 'lawyer-landing-page' ); //For 404
                            
                            /** For Woocommerce */
                            if( lawyer_landing_page_is_woocommerce_activated() && ( is_product_category() || is_product_tag() || is_shop() ) ){
                                if( is_shop() ){
                                    if ( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ) {
                                		return;
                                	}
                                	$_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                                
                                	if ( ! $_name ) {
                                		$product_post_type = get_post_type_object( 'product' );
                                		$_name = $product_post_type->labels->singular_name;
                                	}
                                    echo esc_html( $_name );
                                }elseif( is_product_category() || is_product_tag() ){
                                    $current_term = $GLOBALS['wp_query']->get_queried_object();
                                    echo esc_html( $current_term->name );
                                }
                            }else{
                                if( is_archive() ) the_archive_title();    
                            }
                        ?>
                        </h1>
                    </header>
                    
                    <?php lawyer_landing_page_breadcrumb(); // breadcrumb ?>
                    
        		</div>
        	</div>
        <?php
        }
    }
}
endif;
add_action( 'lawyer_landing_page_before_content', 'lawyer_landing_page_pg_header', 20 );

if( ! function_exists( 'lawyer_landing_page_content_start' ) ) :
/**
 * Content Start
*/
function lawyer_landing_page_content_start(){
    
    $class            = is_404() ? 'error-holder' : 'row' ;
    $enabled_sections = lawyer_landing_page_home_section();
    
    echo '<div id="content" class="site-content">';

    if( is_home() || ! $enabled_sections || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){ ?>    
        <div class="container">
            <div class="<?php echo esc_attr( $class ); ?>">
        <?php
    }
}
endif;
add_action( 'lawyer_landing_page_content', 'lawyer_landing_page_content_start' );

if( ! function_exists( 'lawyer_landing_page_page_content_image' ) ) :
/**
 * Page Featured Image
*/
function lawyer_landing_page_page_content_image(){
    $sidebar_layout = lawyer_landing_page_sidebar_layout();
    if( has_post_thumbnail() ){
        echo '<div class="post-thumbnail">';
        ( is_active_sidebar( 'right-sidebar' ) && ( $sidebar_layout == 'right-sidebar' ) ) ? the_post_thumbnail( 'lawyer-landing-page-with-sidebar', array( 'itemprop' => 'image' ) ) : the_post_thumbnail( 'lawyer-landing-page-without-sidebar', array( 'itemprop' => 'image' ) );    
        echo '</div>';
    }
}
endif;
add_action( 'lawyer_landing_page_before_page_entry_content', 'lawyer_landing_page_page_content_image' );

if( ! function_exists( 'lawyer_landing_page_post_content_image' ) ) :
/**
 * Post Featured Image
*/
function lawyer_landing_page_post_content_image(){
    if( has_post_thumbnail() ){ 
        echo is_single() ? '<div class="post-thumbnail">' : '<a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';    
        
        is_active_sidebar( 'right-sidebar' ) ? the_post_thumbnail( 'lawyer-landing-page-with-sidebar', array( 'itemprop' => 'image' ) ) : the_post_thumbnail( 'lawyer-landing-page-without-sidebar', array( 'itemprop' => 'image' ) );    
        
        echo is_single() ? '</div>' : '</a>';
    }        
}
endif;
add_action( 'lawyer_landing_page_before_post_entry_content', 'lawyer_landing_page_post_content_image', 10 );

if( ! function_exists( 'lawyer_landing_page_post_entry_header' ) ) :
function lawyer_landing_page_post_entry_header(){
    ?>
        <header class="entry-header">
            <?php
                if( is_single() ){
                    the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
                }else{
                    the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                }
                
                if ( 'post' === get_post_type() ){ 
                    lawyer_landing_page_get_post_meta(); 
                } 
            ?>
        </header><!-- .entry-header -->
    <?php
}
endif;
add_action( 'lawyer_landing_page_before_post_entry_content', 'lawyer_landing_page_post_entry_header', 20 );

if( ! function_exists( 'lawyer_landing_page_post_author' ) ) :
/**
 * Author Bio
 * 
*/
function lawyer_landing_page_post_author(){
    if( get_the_author_meta( 'description' ) ){
    ?>
    <section class="author">
		<h2 class="title"><?php esc_html_e( 'About Author', 'lawyer-landing-page' ); ?></h2>
		<div class="holder">
			<div class="img-holder"><?php echo get_avatar( get_the_author_meta( 'ID' ), 126 ); ?></div>
			<div class="text-holder">
				<h3 class="name"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h3>				
				<?php echo wpautop( esc_html( get_the_author_meta( 'description' ) ) ); ?>
			</div>
		</div>
	</section>
    <?php  
    }  
}
endif;
add_action( 'lawyer_landing_page_after_post_content', 'lawyer_landing_page_post_author', 20 );

if( ! function_exists( 'lawyer_landing_page_get_comment_section' ) ) :
/**
 * Comment template
 * 
*/
function lawyer_landing_page_get_comment_section(){
    // If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
}
endif;
add_action( 'lawyer_landing_page_comment', 'lawyer_landing_page_get_comment_section' );

if( ! function_exists( 'lawyer_landing_page_content_end' ) ) :
/**
 * Content End
*/
function lawyer_landing_page_content_end(){
    $enabled_sections = lawyer_landing_page_home_section();
    if( is_home() || ! $enabled_sections || ! ( is_front_page()  || is_page_template( 'template-home.php' ) ) ){ ?>
            </div><!-- .row/not-found -->
        </div><!-- .container -->    
        <?php
    }
    echo '</div><!-- #content -->';
}
endif;
add_action( 'lawyer_landing_page_after_content', 'lawyer_landing_page_content_end', 20 );

if( ! function_exists( 'lawyer_landing_page_footer_start' ) ) :
/**
 * Footer Start
*/
function lawyer_landing_page_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'lawyer_landing_page_footer', 'lawyer_landing_page_footer_start', 20 );

if( ! function_exists( 'lawyer_landing_page_footer_top' ) ) :
/**
 * Footer Top
*/
function lawyer_landing_page_footer_top(){    
    if( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ){
    ?>
    <div class="footer-t">
		<div class="container">
			<div class="row">
				<?php if( is_active_sidebar( 'footer-one' ) ){ ?>
					<div class="column">
					   <?php dynamic_sidebar( 'footer-one' ); ?>	
					</div>
                <?php } ?>
				
                <?php if( is_active_sidebar( 'footer-two' ) ){ ?>
                    <div class="column">
					   <?php dynamic_sidebar( 'footer-two' ); ?>	
					</div>
                <?php } ?>
                
                <?php if( is_active_sidebar( 'footer-three' ) ){ ?>
                    <div class="column">
					   <?php dynamic_sidebar( 'footer-three' ); ?>	
					</div>
                <?php } ?>
			</div>
		</div>
	</div>
    <?php 
    }   
}
endif;
add_action( 'lawyer_landing_page_footer', 'lawyer_landing_page_footer_top', 30 );

if( ! function_exists( 'lawyer_landing_page_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function lawyer_landing_page_footer_bottom(){
    $copyright_text = get_theme_mod( 'lawyer_landing_page_footer_copyright_text' );
    ?>
    <div class="footer-b">
		<div class="container">
			<div class="site-info">
				<span class="copyright">
                    <?php
                    if( $copyright_text ){
                        echo wp_kses_post( $copyright_text );
                    }else{
                        esc_html_e( '&copy; Copyright ', 'lawyer-landing-page' ); 
                        echo date_i18n( esc_html__( 'Y', 'lawyer-landing-page' ) );
                        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>.';    
                    }
                ?>
                </span> 
                <span class="by">
                    <?php echo esc_html__( 'Lawyer Landing Page | Developed By', 'lawyer-landing-page' ); ?>
                    <a href="<?php echo esc_url( 'https://rarathemes.com/' ); ?>" rel="nofollow" target="_blank"><?php echo esc_html__( 'Rara Theme', 'lawyer-landing-page' ); ?></a>.
                    <?php printf( esc_html__( 'Powered by %s', 'lawyer-landing-page' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'lawyer-landing-page' ) ) .'" target="_blank">WordPress</a>' ); ?>.
                    <?php
                    if ( function_exists( 'the_privacy_policy_link' ) ) {
                        the_privacy_policy_link();
                    }
                    ?>
                </span>                
			</div>
		</div>
	</div>
    <?php
}
endif;
add_action( 'lawyer_landing_page_footer', 'lawyer_landing_page_footer_bottom', 40 );

if( ! function_exists( 'lawyer_landing_page_footer_end' ) ) :
/**
 * Footer End 
*/
function lawyer_landing_page_footer_end(){
    ?>
    </footer><!-- #colophon -->
    <div class="overlay"></div>
    <?php
}
endif;
add_action( 'lawyer_landing_page_footer', 'lawyer_landing_page_footer_end', 50 );

if( ! function_exists( 'lawyer_landing_page_page_end' ) ) :
/**
 * Page End
*/
function lawyer_landing_page_page_end(){
    ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'lawyer_landing_page_after_footer', 'lawyer_landing_page_page_end', 20 );