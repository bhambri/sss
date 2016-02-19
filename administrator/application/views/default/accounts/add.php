<div class="page">
<table border="0" cellspacing="0" cellpadding="0" class="page_width">
	<tr>
		<td id="id_td_pageHeading" valign="middle">
			<span id="pageTitle">
				<?php
					if($CustomerID) {
						echo 'Update Account :: '.$CustomerID ;
					} else {
						echo ucfirst($caption);
					}
				?>
			</span>
		</td>
    </tr>
	<!-- Errors And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors') || !$meritusEnabled): ?>
			<ul class="error_ul">
				<?php echo $this->session->flashdata('errors'); ?>
				<?php echo (isset($meritusMessage))?($meritusMessage):'';?>
			</ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Errors And Message Display Row > -->
	<!-- Success And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('success')): ?>
			<ul class="success_ul"><?php echo $this->session->flashdata('success');?></ul>
		<?php endif; ?>
		</td>
    </tr>
	<!-- Success And Message Display Row > -->
	<?php if($meritusEnabled) { ?>
	<tr>
		<td id="content_center_td" valign="top">
			<?php echo form_open('accounts/add',array('id'=>'accountsAddPage','name'=>'accountsAddPage', 'onsubmit'=>'return yav.performCheck(\'formAddPage\', rules, \'classic\');'));?>
			<div id="content_div">
				<table width="80%" border="0" cellspacing="0" cellpadding="2" align="center" class="input_table">
					<tr>
						<td class="form_header" colspan="2">
							<span>
								<?php 
									if($CustomerID) {
										echo 'Update Account :: Account already added with id '.$CustomerID ;
									} else {
										echo ucfirst($caption);
									}
								?>
							</span>
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Bank Name: <span> * </span></td>
						<td width="60%"><input type="text" name="BankName" id="BankName"  maxlength = "100" style="width: 150px;" class="inputbox" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Account Name: <span> * </span></td>
						<td width="60%"><input type="text" name="AccountName" id="AccountName"  maxlength = "100" style="width: 150px;" class="inputbox" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Account Number: <span> * </span></td>
						<td width="60%"><input type="text" name="AccountNumber" id="AccountNumber"  maxlength = "100" style="width: 150px;" class="inputbox" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Routing Number: <span> * </span></td>
						<td width="60%"><input type="text" name="RoutingNumber" id="RoutingNumber"  maxlength = "100" style="width: 150px;" class="inputbox" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="input_form_caption_td" width="40%">Bank Account Type: <span> * </span></td>
						<td width="60%"><input type="text" name="BankAccountType" id="BankAccountType"  maxlength = "100" style="width: 150px;" class="inputbox" /></td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="40" valign="bottom">
							<input type="submit" name="submit" class="button" value="Add" />
							<input type="hidden" name="formSubmitted" value="1" class="button" />
						</td>
					</tr>
					<tr>
						<td colspan='2' class="form_base_header" align="center"><?php echo lang("mandatory_fields_notice"); ?></td>
					</tr>
				</table>
			</div>
			<?php echo form_close();?>
		</td>
    </tr>
	<?php } ?>
</table>
</div>