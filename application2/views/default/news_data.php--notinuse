<div class="main_content">
	<h1 class="mainheading">News</h1>
	<?php 
	if(!empty($content)) { 
		$replacestr = array(' ','-');
		$eplacewith = array('-','-') ;
		?>
	<?php 
	foreach ($content as $news) { 
		?>
		<div class="news_area">
		<p>
			<?php if($news->page_thumbnailpath && @file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/php/dog_day_care/'.trim($news->page_thumbnailpath))) { ?>
			<span class="news_thumb_image"><img src="<?php echo base_url()?>/<?php echo $news->page_thumbnailpath ;?>" /></span>
			<?php }else{ ?>
			<span class="news_thumb_image"><img src="<?php echo base_url()?>/application/views/default/img/dog.jpg" /></span>
			<?php } ?>
			<span class="news_content">
					<span class="heading"><?php echo $news->page_title; ?></span></br>
				<span class="date"><?php echo $news->created; ?></span></br>
			<?php echo $news->page_shortdesc; ?>
			<br/>
			<a href="<?php echo base_url() ; ?>news/<?php echo strtolower(str_replace($replacestr,$eplacewith ,$news->page_title)); ?>/<?php echo $news->id; ?>" class="readmore">Read More</a>
		
		</span>
		</p>
		</div>
		<div class="clr"></div>
	<?php } 
	echo '<div id="news_pagination">'.$pagination.'</div>' ;
	?>	
	<?php  }else{
		echo 'No News available' ;	
	} ?>
</div>
<div class="clr"></div>