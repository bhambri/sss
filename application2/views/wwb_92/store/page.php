<?php
$segs =  $this->uri->segments ;
?>
<div class="wid_100" align="center">
<?php if(in_array($segs[2],array('company-profile')) || in_array($segs[1],array('company-profile')) ){?>
<img src="../../../application/views/wwb_92/store/images/company_profile.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('products-power')) || in_array($segs[1],array('products-power'))){?>
<img src="../../../application/views/wwb_92/store/images/gold-silver1.jpg" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('services')) || in_array($segs[1],array('services')) ){?>
<img src="../../../application/views/wwb_92/store/images/legal.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('opportunity')) || in_array($segs[1],array('opportunity')) ){?>
<img src="../../../application/views/wwb_92/store/images/oppur_bg.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('contact-us')) || in_array($segs[1],array('contact-us')) ){?>
<img src="../../../application/views/wwb_92/store/images/contact_bg.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('numismatic-coins')) || in_array($segs[1],array('numismatic-coins')) ){?>
<img src="../../../application/views/wwb_92/store/images/banner_coins1.jpg" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('atcost-bullion')) || in_array($segs[1],array('atcost-bullion')) ){?>
<img src="../../../application/views/wwb_92/store/images/banner_coins1.png" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('culture')) || in_array($segs[1],array('culture')) ){?>
<img src="../../../application/views/wwb_92/store/images/culture_bg.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('executive_team')) || in_array($segs[1],array('executive_team')) ){?>
<img src="../../../application/views/wwb_92/store/images/executive_team.png" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('policies_procedures')) || in_array($segs[1],array('policies_procedures')) ){?>
<img src="../../../application/views/wwb_92/store/images/policies_procedures_bg.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('products-passion')) || in_array($segs[1],array('products-passion')) ){?>
<img src="../../../application/views/wwb_92/store/images/product_passion.jpg" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('theft_service')) || in_array($segs[1],array('theft_service')) ){?>
<img src="../../../application/views/wwb_92/store/images/theft_bg.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('tax_service')) || in_array($segs[1],array('tax_service')) ){?>
<img src="../../../application/views/wwb_92/store/images/tax_bg.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('recognition')) || in_array($segs[1],array('recognition')) ){?>
<img src="../../../application/views/wwb_92/store/images/reco_bg.gif" /></div>
<?php } ?>

<?php if(in_array($segs[2],array('compensation-plan')) || in_array($segs[1],array('compensation-plan')) ){?>
<img src="../../../application/views/wwb_92/store/images/plan_nbg.gif" /></div>
<?php } ?>

<div class="no_topspacing" id="inner_content">
<div class="inner_left">
<ul class="left_nav">
<?php if(in_array($segs[2],array('company-profile','contact-us','culture','executive_team','policies_procedures')) 
){ ?>
<li><a class="<?php if($segs[2] == 'company-profile'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/company-profile">Company Profile</a></li>
<li><a class="<?php if($segs[2] == 'culture'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/culture">Culture</a></li>
<li><a class="<?php if($segs[2] == 'executive_team'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/executive_team">Executive Team</a></li>
<li><a class="<?php if($segs[2] == 'contact-us'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/contact-us">Contact Us</a></li>
<li><a class="<?php if($segs[2] == 'policies_procedures'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/policies_procedures">Policies and Procedures</a></li>
<?php } ?>
<!-- new con section -->
<?php if(in_array($segs[1],array('company-profile','contact-us','culture','executive_team','policies_procedures')) 
){ ?>
<li><a class="<?php if($segs[1] == 'company-profile'){ echo 'active' ; }?>" href="<?php echo site_url();?>company-profile">Company Profile</a></li>
<li><a class="<?php if($segs[1] == 'culture'){ echo 'active' ; }?>" href="<?php echo site_url();?>culture">Culture</a></li>
<li><a class="<?php if($segs[1] == 'executive_team'){ echo 'active' ; }?>" href="<?php echo site_url();?>executive_team">Executive Team</a></li>
<li><a class="<?php if($segs[1] == 'contact-us'){ echo 'active' ; }?>" href="<?php echo site_url();?>contact-us">Contact Us</a></li>
<li><a class="<?php if($segs[1] == 'policies_procedures'){ echo 'active' ; }?>" href="<?php echo site_url();?>policies_procedures">Policies and Procedures</a></li>
<?php } ?>
<!-- new section ends -->
<?php if(in_array($segs[2],array('products-power','products-passion','numismatic-coins','atcost-bullion'))){ ?>
<li><a class="<?php if($segs[2] == 'products-power'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/products-power">The Power of Precious Metals</a></li>
<li><a class="<?php if($segs[2] == 'products-passion'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/products-passion">The Passion to Prosper and Protect</a></li>
<li><a class="<?php if($segs[2] == 'atcost-bullion'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/atcost-bullion">At Cost Bullion</a></li>
<li><a class="<?php if($segs[2] == 'numismatic-coins'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/numismatic-coins">Numismatic "Collectable" coins</a></li>
<li><a href="<?php echo site_url();?><?php echo $segs[1] ; ?>/store/product">Shop Online</a></li>
<?php } ?>

<!-- new section -->
<?php if(in_array($segs[1],array('products-power','products-passion','numismatic-coins','atcost-bullion'))){ ?>
<li><a class="<?php if($segs[1] == 'products-power'){ echo 'active' ; }?>" href="<?php echo site_url();?>products-power">The Power of Precious Metals</a></li>
<li><a class="<?php if($segs[1] == 'products-passion'){ echo 'active' ; }?>" href="<?php echo site_url();?>products-passion">The Passion to Prosper and Protect</a></li>
<li><a class="<?php if($segs[1] == 'atcost-bullion'){ echo 'active' ; }?>" href="<?php echo site_url();?>atcost-bullion">At Cost Bullion</a></li>
<li><a class="<?php if($segs[1] == 'numismatic-coins'){ echo 'active' ; }?>" href="<?php echo site_url();?>numismatic-coins">Numismatic "Collectable" coins</a></li>
<li><a href="<?php echo site_url();?>store/product">Shop Online</a></li>
<?php } ?>
<!-- new section ends now -->
<?php if(in_array($segs[2],array('services','theft_service','tax_service'))){ ?>
<li> <a class="<?php if($segs[2] == 'services'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/services">Legal Services</a> </li>
<li> <a class="<?php if($segs[2] == 'theft_service'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/theft_service">Identity Theft Services</a> </li>
<li> <a class="<?php if($segs[2] == 'tax_service'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/tax_service">WWB Tax Services</a> </li>
<?php } ?>
<!-- new sect -->
<?php if(in_array($segs[1],array('services','theft_service','tax_service'))){ ?>
<li> <a class="<?php if($segs[1] == 'services'){ echo 'active' ; }?>" href="<?php echo site_url();?>services">Legal Services</a> </li>
<li> <a class="<?php if($segs[1] == 'theft_service'){ echo 'active' ; }?>" href="<?php echo site_url();?>theft_service">Identity Theft Services</a> </li>
<li> <a class="<?php if($segs[1] == 'tax_service'){ echo 'active' ; }?>" href="<?php echo site_url();?>tax_service">WWB Tax Services</a> </li>
<?php } ?>

<!-- new sect ends -->
<?php if(in_array($segs[2],array('opportunity','recognition','compensation-plan'))){ ?>
<li><a class="<?php if($segs[2] == 'opportunity'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/opportunity">Opportunity</a></li>
<li><a class="<?php if($segs[2] == 'recognition'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/recognition">Recognition</a></li>
<li><a class="<?php if($segs[2] == 'compensation-plan'){ echo 'active' ; }?>" href="<?php echo site_url();?><?php echo $segs[1] ; ?>/compensation-plan">Compensation Plan</a></li>
<li><a href="<?php echo site_url();?><?php echo $segs[1] ; ?>/user/register">Sign Up Now</a></li>
<?php } ?>

<!-- new section -->
<?php if(in_array($segs[1],array('opportunity','recognition','compensation-plan'))){ ?>
<li><a class="<?php if($segs[1] == 'opportunity'){ echo 'active' ; }?>" href="<?php echo site_url();?>opportunity">Opportunity</a></li>
<li><a class="<?php if($segs[1] == 'recognition'){ echo 'active' ; }?>" href="<?php echo site_url();?>recognition">Recognition</a></li>
<li><a class="<?php if($segs[1] == 'compensation-plan'){ echo 'active' ; }?>" href="<?php echo site_url();?>compensation-plan">Compensation Plan</a></li>
<li><a href="<?php echo site_url();?>user/register">Sign Up Now</a></li>
<?php } ?>
<!-- new section ends now -->

</ul>
</div>
<?php echo $page_content; ?>
<!--
<div class="inner-right">
<h2>Company Profile</h2>
<p>WorldWide Bullionaires was founded on the principles of helping individuals create and protect wealth with premium products and a powerful opportunity. To accomplish this WWB has harnessed the power of direct sales to help spread the message of owning Gold and Silver. We help make the process simple and affordable</p>
<h2>Precious Metals</h2>
<p>The premium products include "at cost" bullion, collectable "numismatic" coins as well as other vital services to protect and preserve wealth. Our mission is to help our associates build a company within a company. We believe there is room for the serious business builder to achieve their dreams as well as the individual that wants to earn additional income.</p>
</div>
-->

</div>
