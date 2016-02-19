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
#die;
function print_tree($arr, $lvlval=0)
{
	$lvlval = $lvlval + 1 ;
	if($lvlval > 50){
		return ;
		//echo 'print data';
	}
	foreach ($arr as $key => $treeView) {
	# code...
	
	//die;
		echo '<ul>';
		
			echo '<li><a href='.$treeView['details']['id'].'>'.$treeView['details']['username'].'</a></li>' ;	
		
			if(is_array($treeView['childs']) && !empty($treeView['childs'])){
				print_tree($treeView['childs'],$lvlval );
			}
			echo '</ul>' ;
		
	}
}
print_tree($tree ,0);
/*
foreach ($tree as $key => $treeView) {
	# code...
	
	//die;
	echo '<ul>';
	if($key== 'details'){
		echo '<li><a href='.$treeView['id'].'>'.$treeView['username'].'</a></li>' ;
	}
	//echo '<pre>' ;
	//print_r($treeView) ;
	if($key == 'childs'){
		//echo '<pre>';
		
		if(is_array($treeView['childdetails']) && !empty($treeView['childdetails'])){
			echo '<ul>' ;
			foreach ($treeView['childdetails'] as $key => $value1) {
				# code...
				//echo '<pre>' ;
				//print_r($value1) ;
				//echo $key ;
				//print_r() ;
				echo '<li><a href='.$key.'>'.$treeView['details'][$key]['username'].'</a></li>' ;
				if(is_array($value1['childdetails']) && !empty($value1['childdetails'])){
					echo '<ul>' ;
					//print_r($value1) ;
					foreach ($value1['childdetails'] as $key11 => $value11) {
						# code...
						echo '<li><a href='.$key11.'>'.$value1['details'][$key11]['username'].'</a></li>' ;
						#echo '<pre>' ;
						#echo $key11 ;
						#print_r($value11) ;
						///
						if(is_array($value11['childdetails']) && !empty($value11['childdetails'])){
								echo '<ul>' ;
								//print_r($value1) ;
								foreach ($value11['childdetails'] as $key111 => $value111) {
									# code...
									echo '<li><a href='.$key111.'>'.$value11['details'][$key111]['username'].'</a></li>' ;
									#echo '<pre>' ;
									#echo $key111 ;
									#print_r($value111) ;
									/// next lvl
									if(is_array($value111['childdetails']) && !empty($value111['childdetails'])){
										echo '<ul>' ;
										//print_r($value1) ;
										foreach ($value111['childdetails'] as $key1111 => $value1111) {
											# code...
											echo '<li><a href='.$key1111.'>'.$value111['details'][$key1111]['username'].'</a></li>' ;
											#echo '<pre>' ;
											#echo $key111 ;
											#print_r($value111) ;
											/// next lvl
											
											/// nx lvl
										}
										echo '</ul>' ;
									}
									/// nx lvl
								}
								echo '</ul>' ;
							}
						///
					}
					echo '</ul>' ;
				}
				//die;
			}
			echo '</ul>' ;
		}
		
	}
	echo '</ul>';
}
*/
?>
</td>	
    </tr>
    <tr> </tr>
</table>
</div>
