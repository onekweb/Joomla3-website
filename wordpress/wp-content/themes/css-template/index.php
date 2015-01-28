<?php get_header(); ?>
 <div id="container">
	<div id="header">
		<h1>
			<a href="<?php echo home_url('sample-page/'); ?>">Onekweb</a>
		</h1>                

	</div>
 
	<div id="navigation">
		<ul>
		<?php wp_list_pages('title_li='); ?>
		</ul>
	</div>
	<div id="content">
		
		<?php if(have_posts()) : while(have_posts()): the_post(); ?>
			<h1><?php the_title();?></h1>
			<?php the_content();?>
		<?php endwhile; endif; ?>
	</div>
<?php get_footer(); ?>