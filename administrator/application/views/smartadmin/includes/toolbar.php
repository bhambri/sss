<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="Layer1" class="page_width">
	<div id="toolbar" style="display:none;">	
		<table cellpadding="0" cellspacing="0" border="0" id="shortcut_icons_table" width="100%">
			<tr>
				<td class="id_shortcut_icon_td" nowrap="nowrap"><span class="shortcut_icon"><a href="<?php echo $this->config->item('root_url');?>" target="_blank" style="text-decoration:none"><img src="<?php echo layout_url('default/images')?>/icons/home_small.png" border="0" align="middle" class="top_icon" alt="administrator" /><br />
				Site Home</a></span></td>
				
				<td class="id_shortcut_icon_td" nowrap="nowrap"><span class="shortcut_icon"><a href="<?php echo base_url()."content/manage_content"?>" style="text-decoration:none"><img src="<?php echo layout_url('default/images')?>/icons/misc_small.png" border="0" align="middle" class="top_icon" alt="Manage Content" /><br />
				Manage Content</a></span></td>

				<td class="id_shortcut_icon_td" nowrap="nowrap"><span class="shortcut_icon"><a href="<?php echo base_url()."contact/manage_contact"?>" style="text-decoration:none"><img src="<?php echo layout_url('default/images')?>/icons/order_small.png" border="0" align="middle" class="top_icon" alt="Manage Contact Us" /><br />
				Manage Contact Us</a></span></td>

				<td class="id_shortcut_icon_td" nowrap="nowrap"><span class="shortcut_icon"><a href="<?php echo base_url()."user/manage_user"?>" style="text-decoration:none"><img src="<?php echo layout_url('default/images')?>/icons/user2_small.png" border="0" align="middle" class="top_icon" alt="Manage Orders" /><br />
				Manage Users</a></span></td>

				
			  <td class="id_shortcut_icon_td" colspan="11" width="100%">&nbsp;</td>
			  <td class="id_shortcut_icon_td" nowrap="nowrap"><span class="shortcut_icon"><a href="javascript:printPage();"><img alt="administrator" src="<?php echo layout_url('default/images')?>/icon_printer.gif" border="0" align="middle" class="top_icon" /><br />
				Print this page</a></span> </td>
			</tr>
		</table>
	</div>
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
   <tr>
      <td id="id_toggle_icons_button" valign="top" colspan="14"><a href="javascript:toggleShortcutBar();"><img alt="administrator" src="<?php echo layout_url('default/images')?>/btn_show_shortcuts.png" border="0" name="toggle" id="toggle" title="Show Shortcuts" style="cursor: hand" /></a> </td>
    </tr>
  </table>
</div>
