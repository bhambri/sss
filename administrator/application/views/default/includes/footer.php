<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
								
	<tr class='foooter_button_bar'>
		<td id='id_footer_td'>
			<div id="div_footer">
			<a href="javascript:bookmark();" class="footer_links"><?php echo lang('footer_bookmark')?></a> | 
			<?php printf(lang('copy_right'),lang('site_name'));?> 
<?php 
if(($_SERVER['HTTP_HOST'] == 'http://simplesalessystems.com') || ($_SERVER['HTTP_HOST'] == 'http://www.simplesalessystems.com')){
printf(lang('footer_design_by'),' <a href="'. $this->config->item('site_designed_by').'" target="_blank">'.$this->config->item('site_designed_name').'</a>') ;
}
?>

<br/>

<?php echo lang('footer_best_view_suggestions')?>
			</div>
		</td>	
	</tr>
</table>
</body>
</html> 
