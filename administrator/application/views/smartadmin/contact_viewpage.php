<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-plus fa-fw "></i> <?php echo ucfirst($caption);?></h1>
	</div>
</div>
<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
	<header role="heading">
		<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
		<h2><?php echo ucfirst($caption);?></h2>
		<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
	</header>
	<!-- widget div-->
	<div role="content">
		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->
		</div>
		<!-- end widget edit box -->
		<!-- widget content -->
		<div class="widget-body no-padding">
			<?php echo form_open('content/edit_page/'.$id,array('id'=>'formEditPage','name'=>'formEditPage','class'=>"smart-form"));?>
				<fieldset>
					<section>
						<label class="label">Name: <?php echo $firstname;?></label>
					</section>
					<section>
						<label class="label">Phone: <?php echo $phone;?></label>
					</section>
					<section>
						<label class="label">Email: <?php echo $email;?></label>
					</section>
					<section>
						<label class="label">Request Date: 
						<?php 
							$date = strtotime($request_date);
							echo date("d,M Y",$date);								
						?>
						</label>
					</section>
					<?php if(@$city) { ?>
					<section>
						<label class="label">City: <?php echo wordwrap(htmlentities($city),75,"\n",true);?></label>
					</section>
					<?php } ?>
					<?php if(@$contact_type == 'E'){ ?>
						<section>
							<label class="label">Address: <?php echo wordwrap(htmlentities($address),75,"\n",true);?></label>
						</section>
						<section>
							<label class="label">State: <?php echo wordwrap(htmlentities($state),75,"\n",true);?></label>
						</section>
						<section>
							<label class="label">Zip Code: <?php echo wordwrap(htmlentities($zip_code),75,"\n",true);?></label>
						</section>
						<section>
							<label class="label">When looking to invest: <?php echo wordwrap(htmlentities($looking_to_invest),75,"\n",true);?></label>
						</section>
						<section>
							<label class="label">No of units: <?php echo wordwrap(htmlentities($no_of_units),75,"\n",true);?></label>
						</section>
					<?php } ?>
					<section>
						<label class="label">Comments: <?php echo wordwrap(htmlentities($comments),75,"\n",true);?></label>
					</section>
				</fieldset>
			<?php echo form_close();?>
		</div>
		<!-- end widget content -->
	</div>
	<!-- end widget div -->
</div>