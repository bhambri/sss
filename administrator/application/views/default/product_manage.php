<div class="page">
  <table border="0" cellspacing="0" cellpadding="0" class="page_width">
    <tr>
      <td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row < -->
	<tr>
		<td align="left" valign="top" style="padding:0px 15px 0px 15px;">
		<?php if($this->session->flashdata('errors')): ?>
			<ul class="error_ul"><?php echo $this->session->flashdata('errors');?></ul>
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
    <tr>
      <td id="content_center_td" valign="top">
          <div id="content_div">
			<div id="listpage_button_bar" >
				<?php echo form_open('product/manage',array('name'=>'search', 'id'=>'search'));?>
				<table align="right"  border="0">
					<tr>
						<td style="padding: 0px 7px 0px 7px;">
							<fieldset class="fieldset">
								<legend><?php echo lang('search')?></legend>
								<div style="margin: 5px; width: 317px;">
								  <input type="text" name="s" id="s" class="inputbox" value="<?php echo form_prep($this->input->get_post('s'));?>" style="margin-bottom:2px;" size="30" />
								  &nbsp;
								  <input type="submit" value="<?php echo lang('btn_search')?>" name="submit" class="button" style="margin-bottom: 2px;" />
								  <br/>
								  <?php echo lang('client_product_search_instructions');?>
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
				<?php echo form_close();?>
				<table align="left" border="0">
					<tr>
						<td class="icon_box" onclick="submitListingForm('memberListing', '<?php echo base_url() . "product/delete"?>','delete');">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/delete.png" alt="Delete" border="0" />
								</td>
								
							</tr>
							<tr>
								<td align="center" class="icon_text">
									<strong><?php echo lang('delete')?></strong>
								</td>
								
							</tr>
							</table>
						</td>
						<?php 
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						<td class="icon_box" onclick="return validate_store_selection();">
						<?php 
						}
						else
						{
						?>
						<td class="icon_box" onclick="submitListingForm('memberListing', '<?php echo base_url() . "product/add"?>','new');">
						<?php
						}
						?>
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">
									<img src="<?php echo layout_url('default/images');?>/icons/notice2.png" alt="Delete" border="0" />
								</td>
								
							</tr>
							<tr>
								<td align="center">
									<strong><?php echo lang('new')?></strong>
								</td>
								
							</tr>
							</table>
						</td>
						<?php 
				//		}
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						<script type="text/javascript">
						function validate_store_selection()
						{
							var vss = document.getElementById("adminid").value;

							if( vss==null || vss==0 || vss=='0' )
							{
								alert("Please select store/client");
								return false;
							}
							else
							{
								 submitListingForm('memberListing', '<?php echo base_url() . "product/add"?>','new');
							}
						}
						</script>
						<td class="icon_box">
							<table border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center">   
                                    <select name="adminid" id="adminid" onchange="setStoreSession(this.value, '<?php echo base_url() . 'product/manage/' ?>', '<?php echo base_url();?>' )">
                                        <option value="0">--Administrator--</option>
                                        <?php foreach ( $clients as $client ) 
                                        {?>
                                        <option value="<?php echo $client->id;?>" <?php if( $this->session->userdata('storeId') == $client->id ) { echo 'selected="selected"'; } ?> ><?php #pr($client) ;
                                        echo $client->username; ?></option>
                                        <?php }?>
                                    </select>
								</td>
								
							</tr>
							<tr>
								<td align="center">
									Select to view the Product
								</td>
								
							</tr>
							</table>
						</td>
						<td class="icon_box">
							<?php echo form_open("product/manage", array('name' => 'uploadCsv', 'id' => 'uploadCsv', 'enctype'=>'multipart/form-data' ) );?>
							<table cellspacing="0" cellpadding="0" border="0" align="center">
								<tbody>
								<tr>
									<td align="center">   
	                                    <input type="file" name="upload_xls">
									</td>
									
								</tr>
								<tr>
									<td align="left">
										<input type="submit" value="Upload CSV">
										<input type="hidden" value="1" name="formSubmitted">
									</td>
									
								</tr>

								</tbody>
							</table>
							<?php echo form_close(); ?>
						</td>
						<td class="icon_box">
							<table cellspacing="0" cellpadding="0" border="0" align="center">
								<tbody>
								<tr>
									<td align="center">   
	                                    <a href="<?php echo base_url(); ?>uploads/sample.csv">View sample format</a>
									</td>
									
								</tr>
								</tbody>
							</table>
						</td>
						<?php 
						}?>
						
						
					</tr>
				</table>
            </div>
			<?php echo form_open("product/manage", array('name' => 'memberListing', 'id' => 'memberListing'));?>
			<input type="hidden" name='page' value="<?php echo $this->uri->segment(3);?>" />
			<input type="hidden" name='s' value="<?php echo $this->uri->segment(4);?>" />
			<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center" class="listing_table">
				<tr>
					<td align="center" class="form_header" width=""><span><input type="checkbox" <?php if(empty($client_product)) { echo "disabled"; }?> name="masterCheckField" id="masterCheckField" onclick="checkAll('memberListing',this);"/></span></td>
					<!--<td align="center" class="form_header"><span>Category</span></td>-->
					<td align="center" class="form_header" ><span>Product Title</span></td>
					<td align="center" class="form_header" ><span>Uploaded Photo</span></td>
					<td align="center" class="form_header"  nowrap="nowrap" align="center"><span>Assign Attributes</span></td>
					<td align="center" class="form_header"  nowrap="nowrap" align="center"><span>AvaTax code</span></td>
					<td align="center" class="form_header"  nowrap="nowrap" align="center"><span>Status</span></td>
				</tr>
				<?php
				
				if($client_product):
					$rowClass = 'row1';

					foreach($client_product as $product):
							
						if($rowClass == 'row0')
						{
							$rowClass = 'row1';
						}
						else
						{
							$rowClass = 'row0';
						}

						//$image_name		=	$client_product_images[0]->image_name;

				?>
				<tr class="<?php echo $rowClass?>">
					<td align="center" width="5%"><span><input type="checkbox" name="client_productids[]" value="<?php echo $product->id?>" onclick="checkMasterState('memberListing', 'masterCheckField')"/></span></td>
					<!--<td align="center"><span><?php echo substr(ucfirst($product->category_name),0,25)?></span></td>-->
					
					<td align="center" ><span><a href="<?php echo base_url()?>product/edit/<?php echo $product->id;?>" ><?php echo $product->product_title;?></a></span></td>				
					
					<td align="center">
						<?php
						 $settings = array('w'=>100,'h'=>100,'crop'=>true);
						 $image = ROOT_PATH . $product->image;
						if( !empty( $product->image )  )
						{
					?>
						<img src="<?php echo ROOT_PATH.'/'.image_resize( $image, $settings);?>" border='0' />
						<?php } else { echo 'No image found!'; } 

						?>
					</td>
					<td nowrap="nowrap" align="center">
						<a href="<?php echo base_url() . "attributesets/assign_attribute/" . $product->id?>"> Assign Attribute</a>
					</td>
					<td nowrap="nowrap" align="center">
						<input type="text" id="<?php echo $product->id; ?>" onchange="updatetaxcode(<?php echo $product->id; ?>);" value="<?php echo $avatax[$product->id] ;?>" />
					</td>				
					<td nowrap="nowrap" align="center">					
					<?php $statusLink = base_url() . "product/update_status/" . $product->id . "/" . $product->status . "/" . $this->uri->segment(3)?>

					<?php if($product->status == 1):?>
						<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/tick.png" alt="active" border="0"/></a>
					<?php else: ?>
						<a href="<?php echo $statusLink;?>" ><img src="<?php echo layout_url('default/images')?>/publish_x.png" alt="deactive" border="0"/></a>
					<?php endif; ?>
					</td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr class='row0'>
					<td colspan="5" align='center' ><strong>No client Product Found.</strong></td>
				</tr>
				<?php endif;?>
				<tr>
					<td colspan="5" align="center">
						<?php echo $pagination; ?>
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="5">
						<input type="button" 
						<?php 
						if( isset( $this->session->userdata['user']['is_admin'] ) ) 
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'admin/desktop';?>';" 
						<?php 
						}
						else
						{
						?>
						onclick="javascript: window.location.href='<?php echo base_url().'client/desktop';?>';"	
						<?php
						}
						?>
						class="button" value="Back">
					</td>
				</tr>
            </table>
			<?php echo form_close(); ?>
          </div>
        </td>
    </tr>
  </table>
  <script  type="text/javascript" src="includes/script/boxover.js" ></script>
  <script>
	function updatetaxcode(pid) {
		textval = jQuery('#'+pid).val() ;
		productid = pid ;

		jQuery.ajax({
	        type:'POST',
	        url :  '/administrator/product/updatetaxcode',
	        data: 'product_id='+productid+'&tax_code='+textval ,
	        success: function(result)
	        {
	            if( result == 1 )
	            {
	                // alert('The product is added to your wishlist.');
	            }
	            else
	            {
	               alert('ATX code updation failed'); 
	            }
	        },
	        error: function(error)
	        {
	            alert(JSON.stringify(error)+'Some error occured. Please try again later');
	        }
    	});
		
	}
</script>
</div>
