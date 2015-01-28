<?php
// gallery data retreival
$feed = $this->data['feed'];
$gallery = $this->data['gallery'];
$mode = $this->data['mode'];
$options = $this->data['options'];

// gallery settings 
$thumbImage = $gallery->getSygStyle()->getThumbImage();
$overlayButtonSrc = (!empty($thumbImage)) ? $this->data['imgPath'] . '/button/play-the-video_' . $gallery->getSygStyle()->getThumbImage() .'.png' : $this->data['imgPath'] . '/button/play-the-video_1.png'; 
?>

<div id="syg_video_gallery-<?php echo $gallery->getId();?>" class="syg_video_gallery_loading-<?php echo $gallery->getId();?> syg_video_gallery-<?php echo $gallery->getId();?>">
	<div class="sc_menu-<?php echo $gallery->getId();?>">
		<ul class="sc_menu-<?php echo $gallery->getId();?>" style="display: none !important;">
			<?php 
				foreach ($feed as $element) {				
					// modify the img path to match local files
					if ($mode == SygConstant::SYG_PLUGIN_FE_CACHING_MODE) {
						$videoThumbnails[$options['syg_option_which_thumb']]['url'] = content_url() .
													SygConstant::WP_CACHE_THUMB_REL_DIR .
													$gallery->getId() . 
													DIRECTORY_SEPARATOR . 
													$element->getVideoId() . '.jpg';
					} else {
						$videoThumbnails = $element->getVideoThumbnails();
					}
				?> 
				<!-- gallery code -->
				<li>
					<a class="sygVideo-<?php echo $gallery->getId();?>" href="http://www.youtube.com/watch?v=<?php echo $element->getVideoId(); ?>" title="<?php echo htmlspecialchars($element->getVideoTitle()); ?>">
						<!-- append video thumbnail -->
						<?php if ($gallery->getDescShow()) { ?>
							<img src="<?php echo $videoThumbnails[$options['syg_option_which_thumb']]['url']; ?>" class="thumbnail-image-<?php echo $gallery->getId();?>" alt="<?php echo htmlspecialchars($element->getVideoDescription()); ?>" title="<?php echo htmlspecialchars($element->getVideoDescription()); ?>"/>
						<?php } else { ?>
							<img src="<?php echo $videoThumbnails[$options['syg_option_which_thumb']]['url']; ?>" class="thumbnail-image-<?php echo $gallery->getId();?>" alt="play" title="play"/>
						<?php }?>				
				
						<!-- show overlay button -->
						<?php if ((!$gallery->getCacheOn()) || (!$gallery->isGalleryCached())) { ?>			
							<img class="play-icon-<?php echo $gallery->getId();?>" src="<?php echo $overlayButtonSrc; ?>" alt="play">
						<?php } ?>
						
						<!-- show video duration -->
						<?php if ($gallery->getDescShowDuration()) { ?>
							<span class="video_duration-<?php echo $gallery->getId();?>"><?php echo SygUtil::formatDuration($element->getVideoDuration()); ?></span>
						<?php } ?>
					</a>
					<!-- show video title -->
					<span class="video_title-<?php echo $gallery->getId();?>"><?php echo htmlspecialchars($element->getVideoTitle()); ?></span>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>

<?php 
// js to include
$url = plugins_url().'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$gallery->getId().'&cache=off'.'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY;
wp_register_script('syg-gallery-ready-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY, $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-gallery-ready-'.$gallery->getId().'-'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY);
// js to include
$url = plugins_url().'/sliding-youtube-gallery/js/core/ui/loading/gallery.min.js.php?id='.$gallery->getId();
wp_register_script('syg-gallery-loading-'.$gallery->getId(), $url, array(), SygConstant::SYG_VERSION, true);
wp_enqueue_script('syg-gallery-loading-'.$gallery->getId());
?>