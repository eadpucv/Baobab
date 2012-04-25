<?php
	/* Template Name: Archivo Debates */
	get_header();
?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.jscrollpane.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/prueba.js"></script>

<style type="text/css">
.top-news {
	background:transparent url('<?php if (has_post_thumbnail()) {
    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail_name');
    echo $thumb[0]; // thumbnail url
    }
    ?>');
    background-position: center center;
    background-size: cover;
}
</style>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
	   <?php $opciones = get_votes_from_post_id($post->ID); 
	          if ( $opciones ) {		
			foreach ( $opciones as $opcion ) { ?>
		          ['<?php echo $opcion->vote_text; ?>', <?php echo get_votes($opcion->id); ?>],
	   <?php } } ?>
        ]);
            
        var options = {
          title: ''
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		chart.draw(data, {backgroundColor: 'transparent' });}
    </script>
    
<content>
	<div id="pagewrap">
		<h2>Debates Recientes</h2>
		<a href="<?php $bloginfo = get_bloginfo(); ?>feed/" title="<?php _e('Syndicate this site using RSS'); ?>">
		<img src="http://www.mozilla.org/images/feed-icon-14x14.png" alt="RSS Feed" title="RSS Feed" /></a>
		
		<div class="portada">
			<div class="about">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/portada-debate.png"/>
				<p>Un <span>Debate</span> permite generar discusiones por medio de votaciones y validar tu postura al comentar.</p>
				<?php if ( is_user_logged_in() ) { echo '<a href="/enviar-debate/" class="button color_blue">Crear Debate</a>'; }
				else {echo '<a href="/wp-login.php" class="button color_blue">Inicia Sesión</a>';}
				?>
			</div><!-- about -->
			
			<div class="top-news">
			<a href="<?php the_permalink(); ?>">
				<div class="top-filter">
						<?php $debates = new WP_Query(array('post_type' => 'debate')); if ( $debates->have_posts() ) : $i = 0	; while ( $debates->have_posts() && $i < 1 ) : $debates->the_post(); ?>
						<h4><?php echo titulo_corto ('...', 60);?></h4>
						<p><?php wp_limit_post(150, '...', true) ?></p>
						<p class="top-dato">
						<?php the_title();?> concluye el <span><?php the_modified_date('d-m-Y') ?></span>
						</p>
						<!-- <div id="chart_div" style="width: auto; height: auto; margin-top:-40px"></div> -->
					<?php $i++; endwhile; endif; ?>
				</div><!-- top-filter -->
				</a>
			</div><!-- top-news -->
		</div><!-- portada -->

		<div class="container" id="container">
		<?php $debates = new WP_Query('post_type=debate&offset=-1&posts_per_page=100');if ( $debates->have_posts() ) : while ( $debates->have_posts() ) : $debates->the_post(); ?>
			<?php// if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<figure class="item block">
					<div class="thumbs-wrapper">
						<?php the_post_thumbnail('debate-thumbnail'); ?>
					</div> <!-- thumbs-wrapper -->
					<div class="sub-block">
					<a href="<?php the_permalink(); ?>">
						<h4><?php echo titulo_corto ('...', 60);?></h4>
							<p class="block-text"><?php wp_limit_post(90, '...', true) ?></p>
						</a>

						<p><?php the_time ('j \d\e F, Y')?></p>
						<p><?php the_category(', ') ?></p>
					</div><!-- sub-block -->

					<figcaption id="clickeable" onclick="location.href='<?php the_permalink(); ?>';" style="cursor:pointer;">
						<a href="<?php the_permalink(); ?>">
							<p>"<?php 
							//limit post if has an image
							if(has_post_thumbnail()) {
							echo ''.wp_limit_post(100, '...', true);
							} else {
							echo ''.wp_limit_post(30, '...', true);;
							}
							?>""
							<span><?php the_modified_date('j \d\e F'); ?></span>
							</p>
						</a>
					</figcaption>
				</figure> <!-- item block -->
			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>
<?php get_footer() ?>