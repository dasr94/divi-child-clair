<ul class="et-social-icons">

<?php if ( 'on' === et_get_option( 'divi_show_facebook_icon', 'on' ) ) : ?>
	<li class="et-social-icon et-social-facebook">
		<a href="<?php echo esc_url( et_get_option( 'divi_facebook_url', '#' ) ); ?>" class="icon">
			<span><?php esc_html_e( 'Facebook', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if ( 'on' === et_get_option( 'divi_show_twitter_icon', 'on' ) ) : ?>
	<li class="et-social-icon et-social-twitter">
		<a href="<?php echo esc_url( et_get_option( 'divi_twitter_url', '#' ) ); ?>" class="icon">
			<span><?php esc_html_e( 'Twitter', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if ( 'on' === et_get_option( 'divi_show_google_icon', 'on' ) ) : ?>
	<li class="et-social-icon et-social-google-plus">
		<a href="<?php echo esc_url( et_get_option( 'divi_google_url', '#' ) ); ?>" class="icon">
			<span><?php esc_html_e( 'Google', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if ( 'on' === et_get_option( 'divi_show_rss_icon', 'on' ) ) : ?>
<?php
	$et_rss_url = '' !== et_get_option( 'divi_rss_url' )
		? et_get_option( 'divi_rss_url' )
		: get_bloginfo( 'rss2_url' );
?>
	<li class="et-social-icon et-social-rss">
		<a href="<?php echo esc_url( $et_rss_url ); ?>" class="icon">
			<span><?php esc_html_e( 'RSS', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>


<!-- Agrega tus propios iconos -->


<!--
LINK: https://www.youtube.com/watch?v=JdqIAe9pN3w
RECURSOS PARA ICONOS: https://nosunelanube.com/iconos-redes-sociales-divi/
<li class="et-social-icon et-social-youtube">
	<a target="_blank" href="https://www.youtube.com/" class="icon">
		<span><?php esc_html_e( 'YouTube', 'Divi' ); ?></span>
	</a>
</li>

<li class="et-social-icon et-social-linkedin">
	<a target="_blank" href="https://www.youtube.com/" class="icon">
		<span><?php esc_html_e( 'LinkedIn', 'Divi' ); ?></span>
	</a>
</li>
	
<li class="et-social-icon">
	<a href="https://api.whatsapp.com/send?phone=50325248345&text=%C2%A1los%20contacto%20desde%20la%20web!" class="icon">
		<i class="fab fa-whatsapp"></i>
	</a>
</li>
-->
<!-- Generador de enlaces para whatsapp: https://postcron.com/es/blog/landings/generador-de-enlaces-para-whatsapp/ 
<li class="et-social-icon">
	<a href="mailto:estanciageriatrica.121@gmail.com?subject=Contacto%20desde%20la%20web&body=%C2%A1Hola!%2C%20te%20contacto%20desde%20la%20web" class="icon">
		<i class="far fa-envelope"></i>
	</a>
</li>
-->


</ul>