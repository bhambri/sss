<div class="main_content">
	<h1 class="mainheading">News</h1>
	<?php if($content) { 
		$replacestr = array(' ','-');
		$eplacewith = array('-','-') ;
		?>

		<div class="news_area">
		<p>
			<?php if($content->page_thumbnailpath && file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/php/dog_day_care/'.trim($content->page_thumbnailpath)) ){  ?>
			<span class="news_thumb_image"><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/php/dog_day_care/' ?><?php echo $content->page_thumbnailpath ; ?>"></span>
			<?php }else{ ?>
			<span class="news_thumb_image"><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/php/dog_day_care/' ?>application/views/default/img/dog.jpg"></span>
			<?php } ?>
			<span class="news_content" style="width:80%;">
			<span class="heading"><?php echo $content->page_title; ?></span></br>
			<span class="date"><?php echo $content->created; ?></span></br>
			<!-- <div> --><?php echo $content->page_content; ?><!-- </div> -->
			<br/>
			<?php if(@$_SERVER['HTTP_REFERER']){ ?>
			<a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="readmore" style="margin-top:5px;">Back</a>
			<?php }else{ ?>
				<a href="<?php echo base_url() ?>news" class="readmore" style="margin-top:5px;">Back</a>
			<?php } ?>

		</span>
		<br/>
		</p>
		</div>
		<div class="clr"></div>
		<div>
		<?php # if(@$_SERVER['HTTP_REFERER']){ ?>
			<!-- <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="readmore">Back</a> -->
		<?php # }else{ ?>
			<!-- <a href="<?php echo base_url() ?>news" class="readmore">Back</a> -->
		<?php # } ?> 
		</div>
	<?php }else{
		echo 'No news data available' ;	
	} ?>
</div>
<div class="clr"></div>