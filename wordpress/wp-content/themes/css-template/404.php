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
		<h2>Not found </h2>
		<p>
			
			"Oops, I screwed up and you discovered my fatal flaw. 
			Well, we're not all perfect, but we try. 
		</p>
		<p>
			 Can you try this
			again or maybe visit our <a href="<?php echo home_url('/'); ?>">Home 
			Page</a> to start fresh.  We'll do better next time."
			
		</p>
	</div>
<?php get_footer(); ?>