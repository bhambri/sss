<script type="text/javascript" language="javascript">
//<![CDATA[
	var rules = new Array();
	rules[0] = 'email:<?php echo lang("email")?>|required';
	rules[1] = 'email:<?php echo lang("email")?>|email';
//]]>
</script>
<!-- Below table will display error messages if any -->
<?php if (strlen(validation_errors()) > 1)  : ?>
<table border="0" cellspacing="0" cellpadding="4" align="center" width="440">
	<tr>
		<td align="left"><ul class="error_ul"><li><strong>Please correct the following:<br/><br/></strong></li><?php echo validation_errors('<li>','</li>');?></ul></td>
	</tr>
</table>
<?php endif; ?>
<?php if($this->session->flashdata('success')): ?>
<table border="0" cellspacing="0" cellpadding="4" align="center" width="440">
	<tr>
		<td align="left"><ul class="success_ul"><?php echo validation_errors();?><?php echo $this->session->flashdata('success');?></ul></td>
	</tr>
</table>
<?php endif; ?>
<?php if($this->session->flashdata('errors')): ?>
<table border="0" cellspacing="0" cellpadding="4" align="center" width="440">
	<tr>
		<td align="left"><ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul></td>
	</tr>
</table>
<?php endif; ?>
<table border="0" cellspacing="0" cellpadding="4" align="center" width="440">
	<tr>
		<td align="left">
			<div id="errorsDiv"></div>
		</td>
	</tr>
</table>

<?php 
$attr = array('name'=>'adminForgot','id'=>'adminForgot','onsubmit'=>"return yav.performCheck('adminForgot', rules, 'innerHtml');");
echo form_open('client/forgot_password', $attr);
?>

<table border="0" cellspacing="0" cellpadding="4" align="center" id="id_table_login_form">
	<tr>
		<td valign="top" width="175">
		<!-- Below table prints the left side introduction text -->
			<table cellpadding="0" cellspacing="0" border="0" width="175">
				<tr>
					<td valign="top" align="center"><img src="<?php echo layout_url('default/images')?>/security.png" width="64" height="64" border="0" vspace="10" alt="Login" /></td>
				</tr>
				<tr>
					<td valign="top" align="center" height="5"></td>
				</tr>
				<tr>
					<td valign="top" class="small"><?php printf(lang('login_forgotpassword_text'),lang('site_name'));?><br /><br />
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" width="237">
			<!-- Below table provides login fields to get access to admin area -->
			<table cellpadding="0" cellspacing="0" border="0">
				<!-- Login Image Row -->
				<tr>
					<td valign="top"><img src="<?php echo layout_url('default/images')?>/forgot_password.gif" border="0" vspace="10" alt="Login" /></td>
				</tr>
				<tr>
					<td valign="top" width="239">
						<table cellpadding="0" cellspacing="0" border="0" id="id_table_form_inner">
							<tr>
								<td valign="top" height="10" colspan="2"></td>
							</tr>
							<tr>
								<td width="10" height="18" valign="top"></td>
								<td valign="top"><strong><?php echo lang("email"); ?>*</strong></td>
							</tr>
							<tr>
								<td width="10" height="19" valign="top"></td>
								<td valign="top"><input name="email" type="text" class="inputbox" id="email" size="25" maxlength="100" /></td>
							</tr>
							<tr>
								<td valign="top" width="10"></td>
								<td valign="top" height="10"></td>
							</tr>
							<tr>
								<td valign="top" width="10"></td>
								<td valign="top" height="10"></td>
							</tr>
							<tr>
								<td valign="top" width="10"></td>
								<td valign="top" >
								<!-- Below forgot password row -->
									<table width='80%' cellspacing='0' border='0'>
										<tr>
											<td>
												<input type="submit" value="<?php echo lang('btn_retrieve')?>" name="submit" class="btnlogin" />
											</td>
											<td><?php echo anchor('client/index',lang('btn_login'))?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top" width="10"></td>
								<td valign="top" height="10"></td>
							</tr>
							<tr>
								<td valign="top" width="10"></td>
								<td valign="top"><strong><?php echo lang('thm')?></strong></td>
							</tr>
							<!-- Below row will provide function to select different themes -->
							<tr>
								<td width="10"></td>
								<td>
									<select name="selTheme" id="selTheme" onchange="loadStyle(this.value)" class="inputbox0">
										<option value="default"><?php echo lang('default_thm')?></option>
										<option value="blue"><?php echo lang('thm_blue')?></option>
										<option value="green"><?php echo lang('thm_green')?></option>
										<option value="purple"><?php echo lang('thm_purple')?></option>
										<option value="grey"><?php echo lang('thm_grey')?></option>
										<option value="mosaic"><?php echo lang('thm_mosaic')?></option>
										<option value="snowy"><?php echo lang('thm_snowy')?></option>
										<option value="transparent"><?php echo lang('thm_transparent')?></option>
									</select>
									<!-- Below javascript is used to set the selected theme in the above dropdown different page loads -->
									<script type="text/javascript">
										mycookies = document.cookie;
										
										if (mycookies.search("global-green") > 0) {
											document.getElementById('selTheme').value = "green";
										} else if ((mycookies.search("global-blue") > 0)) {
											document.getElementById('selTheme').value = "blue";
										} else if ((mycookies.search("global-purple") > 0)) {
											document.getElementById('selTheme').value = "purple";
										} else if ((mycookies.search("global-grey") > 0)) {
											document.getElementById('selTheme').value = "grey";
										} else if ((mycookies.search("global-mosaic") > 0)) {
											document.getElementById('selTheme').value = "mosaic";
										} else if ((mycookies.search("global-snowy") > 0)) {
											document.getElementById('selTheme').value = "snowy";
										} else if ((mycookies.search("global-transparent") > 0)) {
											document.getElementById('selTheme').value = "transparent";
										} else {
											document.getElementById('selTheme').value = "default";
										}
									</script>
								</td>
							</tr>
							<tr>
								<td valign="top" width="10"></td>
								<td valign="top" height="10"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<input type="hidden" name="loginFormSubmitted" value="1" />
<script type="text/javascript">
document.adminForgot.email.focus();
</script>
<?php echo form_close();?>
