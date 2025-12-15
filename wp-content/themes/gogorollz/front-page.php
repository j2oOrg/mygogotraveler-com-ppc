<?php
/**
 * Front page template that reuses the static index.html content.
 */

$index_path   = ABSPATH . 'index.html';
$style_block  = '';
$body_content = '';

if ( file_exists( $index_path ) ) {
    $index_content = file_get_contents( $index_path );

    if ( $index_content !== false ) {
        if ( preg_match( '#<style>(.*?)</style>#is', $index_content, $style_match ) ) {
            $style_block = trim( $style_match[1] );
        }

        if ( preg_match( '#<body[^>]*>(.*?)</body>#is', $index_content, $body_match ) ) {
            $body_content = trim( $body_match[1] );
        }
    }
}

wp_enqueue_style(
    'mygogotraveler-front-fonts',
    'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Bebas+Neue&display=swap',
    [],
    null
);

$inline_css = 'body.home .alert-strip-f2m7, body.home .nav-rail-q5h8 { display:none !important; }';

if ( $style_block ) {
    $inline_css = $style_block . "\n" . $inline_css;
}

wp_add_inline_style( 'mygogotraveler-site', $inline_css );

get_header();

if ( $body_content ) {
    $brand_src    = esc_url( get_theme_file_uri( '/assets/images/img.png' ) );
    $body_content = preg_replace( '#<script[^>]*assets/main\\.js[^>]*></script>#i', '', $body_content );
    $body_content = str_replace( 'src="assets/img.png"', 'src="' . $brand_src . '"', $body_content );

    echo $body_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
    echo '<main class="container py-5"><p>Landing page content not found.</p></main>';
}

wp_footer();
?>
</body>
</html>
