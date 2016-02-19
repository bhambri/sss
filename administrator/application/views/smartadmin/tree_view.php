<div class="page">
<script type='text/javascript' language='javascript'>
//<![CDATA[
	
	
//]]>
</script>
<table border="0" cellspacing="0" cellpadding="0" class="page_width">
	<tr>
		<td id="id_td_pageHeading" valign="middle"><span id="pageTitle"><?php echo ucfirst($caption);?></span></td>
    </tr>
	<!-- Errors And Message Display Row < -->
	<tr>
		
    </tr>
	<!-- Errors And Message Display Row > -->
	<tr>
		<td>
<?php
#echo '<pre>';
#print_r($tree);
foreach ($tree as $key => $treeView) {
	# code...
	#echo '<pre>';
	#print_r($treeView) ;
	
	echo '<ul>';
	if($key== 'detail'){
		echo '<li><a href='.$treeView['id'].'>'.$treeView['username'].'</a></li>' ;
	}

	if($key == 'immediatesuceesor'){
		
		if(is_array($treeView) && !empty($treeView['0'])){
			#echo '<pre>';
			#print_r($treeView) ;

			foreach ($treeView[0] as $keylv1 => $treeViewlv1) {
				# code...
				#echo '<pre>';

				//echo 'key'.$keylv1 ;
				
				if(is_array($treeViewlv1) && !empty($treeViewlv1['detail'])){
					#echo '<pre>'; 
					#print_r($treeViewlv1) ;
					echo '<ul>';
					echo '<li><a href='.$treeViewlv1['detail']['id'].'>'.$treeViewlv1['detail']['username'].'</li>' ;

					//if(!empty($treeViewlv1['immediatesuceesor']) && isset($treeViewlv1['immediatesuceesor'][0])){
					if(!empty($treeViewlv1['immediatesuceesor']['immediatesuceesor'][0])){
						/*
						echo '<pre>';
						print_r($treeViewlv1['immediatesuceesor']['immediatesuceesor'][0]) ;
						echo '</pre>';
						*/

						foreach ($treeViewlv1['immediatesuceesor']['immediatesuceesor'][0] as $keyval2 => $treeViewlv2) {
							# code...
							echo '<ul>';
							echo '<li><a href='.$treeViewlv2['detail']['id'].'>'.$treeViewlv2['detail']['username'].'</li>' ;

							if(!empty($treeViewlv2['immediatesuceesor']['immediatesuceesor'][0])){
								/*
								echo '<pre>';
								print_r($treeViewlv2['immediatesuceesor']['immediatesuceesor'][0]) ;
								echo '</pre>';
								*/
								foreach ($treeViewlv2['immediatesuceesor']['immediatesuceesor'][0] as $keyval3 => $treeViewlv3) {
									# code...
									echo '<ul>';
									echo '<li><a href='.$treeViewlv3['detail']['id'].'>'.$treeViewlv3['detail']['username'].'</li>' ;

									/*
									echo '<pre>';
									print_r($treeViewlv3['immediatesuceesor']['immediatesuceesor'][0]) ;

									echo '</pre>';
									*/
									if(!empty($treeViewlv3['immediatesuceesor']['immediatesuceesor'][0])){
										/*
										echo '<pre>';
										print_r($treeViewlv3['immediatesuceesor']['immediatesuceesor'][0]) ;
										echo '</pre>';
										*/
										foreach ($treeViewlv3['immediatesuceesor']['immediatesuceesor'][0] as $keyval4 => $treeViewlv4) {
											echo '<ul>';
											echo '<li><a href='.$treeViewlv4['detail']['id'].'>'.$treeViewlv4['detail']['username'].'</li>' ;
											/*
											echo '<pre>';
											print_r($treeViewlv4['immediatesuceesor']['immediatesuceesor'][0]) ;
											echo '</pre>';
											*/

											if(!empty($treeViewlv4['immediatesuceesor']['immediatesuceesor'][0])){
												foreach ($treeViewlv4['immediatesuceesor']['immediatesuceesor'][0] as $keyval5 => $treeViewlv5) {
													# code...
													echo '<ul>';
													echo '<li><a href='.$treeViewlv5['detail']['id'].'>'.$treeViewlv5['detail']['username'].'</li>' ;
													/*
													echo '<pre>';
													print_r($treeViewlv5['immediatesuceesor']['immediatesuceesor'][0]) ;
													echo '</pre>';
													*/
													if(!empty($treeViewlv5['immediatesuceesor']['immediatesuceesor'][0])){
														foreach ($treeViewlv5['immediatesuceesor']['immediatesuceesor'][0] as $keyval6 => $treeViewlv6) {
															echo '<ul>';
															echo '<li><a href='.$treeViewlv6['detail']['id'].'>'.$treeViewlv6['detail']['username'].'</li>' ;
															/*
															echo '<pre>';
															print_r($treeViewlv6['immediatesuceesor']['immediatesuceesor'][0] ) ;
															echo '</pre>' ;
															*/
															echo '</ul>';
														}
														/*
														echo '<pre>';
														print_r($treeViewlv5['immediatesuceesor']['immediatesuceesor'][0]) ;
														echo '</pre>';
														*/
													}
													echo '</ul>';
												}

											}
											echo '</ul>' ;
										}
									}
									echo '</ul>' ;
								}

							}
							echo '</ul>' ;
						}
					}
					echo '</ul>' ;
				}

				
				/*
				if($keylv1 == 'detail'){
					echo '<li><a href='.$treeViewlv1['id'].'>'.$treeViewlv1['username'].'</a></li>' ;
				}
				*/
				if($keylv1 == 'immediatesuceesor'){
					
				}

				
			}
		}
	}
	echo '</ul>';
}
?>
</td>	
    </tr>
    <tr> </tr>
</table>
</div>