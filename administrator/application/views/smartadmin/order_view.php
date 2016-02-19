<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
<?php echo form_open('',array('id'=>'formAddPage','name'=>'formAddPage'));?>
	<div class="row">
		<div class="col-xs-12">
			<h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> <?php echo ucfirst($caption);?>
				<section class="pull-right marginBottom10">
					<?php if(empty( $order_view->refund_transaction_id )) { ?>
						<button type="submit" class="btn btn-labeled btn-danger" >Refund</button>
						<input type="hidden" name="transaction_id" value="<?php echo $order_view->transaction_id;?>">
						<input type="hidden" name="gateway" value="<?php echo $order_view->gateway ; ?>">
						<input type="hidden" name="formSubmitted" value="1" />
					<?php } ?>
				</section>
			</h1>
		</div>
	</div>
	<?php if($this->session->flashdata('errors')): ?>
	<div class="alert alert-danger fade in">
		<button class="close" data-dismiss="alert">x</button>
		<i class="fa-fw fa fa-times"></i>
		<strong>Error!</strong> <?php echo $this->session->flashdata('errors');?>
	</div>
	<?php endif; ?>
	<!-- Errors And Message Display Row > -->
	<!-- Success And Message Display Row < -->
	<?php if($this->session->flashdata('success')): ?>
	<div class="alert alert-success fade in">
		<button class="close" data-dismiss="alert">x</button>
		<i class="fa-fw fa fa-check"></i>
		<strong>Success</strong> <?php echo $this->session->flashdata('success');?>
	</div>
	<?php endif; ?>

	<div class="jarviswidget well jarviswidget-color-darken" style="padding:28px 0px;" >
		<article class="col-xs-12">
			<article class="col-xs-6">
				<div class="alert alert-info">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
							<h3 class="no-margin"><?php echo ucfirst($caption);?></h3>
							<ul>
								<li>Buyer: <strong width="23%"><?php echo $order_view->buyer; ?></strong></li>
								<li>Store name: <strong width="23%"><?php echo $order_view->store_name; ?></strong></li>
								<li>Transaction id: <strong width="23%"><?php echo $order_view->transaction_id; ?></strong></li>
								<li>Payment Gateway: <strong width="23%"><?php if($order_view->gateway == 1){ echo 'Maritus' ;}else if($order_view->gateway == 0){echo 'Paypal' ;} else { } ?></strong></li>
								<li>Grand Total: <strong width="23%"><?php echo $order_view->order_amount+$order_view->shipping+$order_view->tax; ?></strong></li>
								
								
								<?php if( !empty( $order_view->refund_transaction_id )) { ?>
									<li>Refund transaction id: <strong width="23%"><?php echo $order_view->refund_transaction_id; ?></strong></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</article>
			<article class="col-xs-6">
				<div class="alert alert-info">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
							<h3 class="no-margin">General Details</h3>
							<ul>
								<li>Customer Name: <strong width="23%"><?php echo $order_view->buyer ;?></strong></li>
								<li>Order date: <strong width="23%"><?php echo $order_view->created_time; ?></strong></li>
								<li>Order Status: 
									<strong width="23%">
										<?php 
											switch($order_view->order_status) {
												case 1:
													echo 'Paid';
													break;
												case 2:
													echo 'Shipped';
													break;
												case 3:
													echo 'Completed';
													break;
												case 4:
													echo 'Cancelled / Refunded';
													break;
											}
										?>
									</strong>
								</li>
								<li>Order Comment: <strong width="23%"><?php if($order_view->order_comment){ echo $order_view->order_comment ; } ?></strong></li>
							</ul>
						</div>
					</div>
				</div>
			</article>
		</article>
		<article class="col-xs-12">
			<?php if(count($billing_shipping['billingdetail']) >0 ){ ?>
				<article class="col-xs-6">
					<div class="alert alert-info">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
								<h3 class="no-margin">Billing Details</h3>
								<?php echo $billing_shipping['billingdetail'][0]->first_name ; ?> <?php echo $billing_shipping['billingdetail'][0]->last_name ; ?>
								<br>
								<?php echo $billing_shipping['billingdetail'][0]->address ; ?><br>
								<?php echo $billing_shipping['billingdetail'][0]->city ; ?> ,<?php echo $billing_shipping['billingdetail'][0]->state_code ; ?> ,<?php echo $billing_shipping['billingdetail'][0]->postal_code ; ?> <br>
								Phone: <?php echo $billing_shipping['billingdetail'][0]->phone_number ; ?> <br/>
								Email: <?php echo $billing_shipping['billingdetail'][0]->email ; ?>
							</div>
						</div>
					</div>
				</article>
			<?php } ?>
			<?php if(count($billing_shipping['shippingdetail']) > 0) { ?>
				<article class="col-xs-6">
					<div class="alert alert-info">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
								<h3 class="no-margin">Shipping Address</h3>
								<?php echo $billing_shipping['shippingdetail'][0]->first_name ; ?> <?php echo $billing_shipping['shippingdetail'][0]->last_name ; ?>
								<br>
								<?php echo $billing_shipping['shippingdetail'][0]->address ; ?><br>
								<?php echo $billing_shipping['shippingdetail'][0]->city ; ?> ,<?php echo $billing_shipping['shippingdetail'][0]->state_code ; ?> ,<?php echo $billing_shipping['shippingdetail'][0]->postal_code ; ?> <br>
								Phone: <?php echo $billing_shipping['shippingdetail'][0]->phone_number ; ?> <br/>
								Email: <?php echo $billing_shipping['shippingdetail'][0]->email ; ?>
							</div>
						</div>
					</div>
				</article>
			<?php } ?>
		</article>
		<!-- widget grid -->
		<article class="col-xs-12">
			<section id="widget-grid" class="">
				<!-- row -->
				<div class="row">
					<!-- NEW WIDGET START -->
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<!-- Widget ID (each widget will need unique ID)-->
						<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
							<header>
								<span class="widget-icon"> <i class="fa fa-table"></i> </span>
								<h2>Order Item</h2>
							</header>
							<!-- widget div-->
							<div>
								<!-- widget edit box -->
								<div class="jarviswidget-editbox">
									<!-- This area used as dropdown edit box -->
								</div>
								<!-- end widget edit box -->
								<!-- widget content -->
								<div class="widget-body no-padding">
									<table id="dt_basic" class="table table-striped table-bordered noMarginBottom" >
										<thead>			                
											<tr>
												<th>Item</th>
												<th>Size</th>
												<th>SKU</th>
												<th>Qty</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($order_detail as $item): ?>
												<tr>
													<td> <?php echo $item->product_title ?> </td>
													<td><?php echo $item->product_size ; ?></td>
													<td><?php echo $item->sku ; ?></td>
													<td><?php echo $item->product_quantity ; ?></td>
													<td>$ <?php echo $item->product_quantity*$item->product_sale_price  ;?></td>
												</tr>
												<tr>
													<td> Specification : </td>
													<td colspan="4"> <?php echo $item->product_specification;?> </td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
								<!-- end widget content -->
							</div>
							<!-- end widget div -->
						</div>
						<!-- end widget -->
					</article>
				</div>
			</section>
		</article>
		<article class="col-xs-12">
			<article class="col-xs-6 pull-right">
				<div class="alert alert-info">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
							<h3 class="no-margin">Order Total</h3>
							<ul>
								<li>Billing (item Sub total): <strong width="23%">$ <?php echo $order_view->order_amount - $order_view->coupon_discount_ammount ; ?></strong></li>
								<li>Shipping: <strong width="23%">$ <?php echo $order_view->shipping; ?></strong></li>
								<li>Tax: <strong width="23%">$ <?php echo $order_view->tax; ?></strong></li>
								<li>Discount Amount: <strong width="23%">$ <?php echo $order_view->coupon_discount_ammount; ?></strong></li>
								<li>Grand Total: <strong width="23%">$<?php echo $order_view->order_amount+$order_view->shipping+$order_view->tax ;?></strong></li>
								
								
								<?php if( !empty( $order_view->refund_transaction_id )) { ?>
									<li>Refund transaction id: <strong width="23%"><?php echo $order_view->refund_transaction_id; ?></strong></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</article>
		</article>
	</div>
<?php echo form_close();?>
</article>
