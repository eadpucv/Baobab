<?php
	/* Template Name: Enviar idea */
	get_header();
?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        	// General options
        	mode : "textareas",
        	theme : "advanced",
theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
theme_advanced_buttons2 : "",
theme_advanced_buttons3 : "",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
});
</script>
<form method="post" action="plantilla-envia-idea.php"></form>


<div id="pagewrap">
<article id="publicacion" class="wrap">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post">
				Crear idea
			</h2>
			<?php endif; ?>
			<?php
				$idea_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$idea = $idea_id ? get_post($idea_id) : null;
			?>

			<form id="formulario-idea" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
					<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h3>Titulo</h3>
						<input class="datos" name="idea[nombre]" type="text" value="<?php echo $idea->post_title ? esc_attr($idea->post_title) : '' ?>"/>

						<h3>Descripción</h3>
						<textarea name="idea[descripcion]" class="text-input descripcion" style="width:100%"><?php echo esc_textarea( $idea->post_content ); ?></textarea>

						<h3>Imagen</h3>
						<input name="idea_imagen" type="file" />

						<h3>Categorías</h3>
						<?php estorninos_category_checkbox('idea', $idea); ?>

						<input class="button color_la" type="submit" value="Enviar" />
						<?php if ( $idea ) { ?>
							<input type="hidden" name="edit" value="true" />
						<?php } ?>
							<input type="hidden" name="action" value="enviar_idea" />
						<?php wp_nonce_field('enviar_idea', '_idea_nonce'); ?>
						
<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->

<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
    echo 'Para realizar una idea debes <a href="http://estorninos.ead.pucv.cl/wp-login.php">Iniciar Sesión</a>.';
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->



				</fieldset>
			</form>
	<?php endwhile; endif; ?>

</article> <!-- publicacion -->


</div> <!-- pagewrap -->	
<?php get_footer(); ?>