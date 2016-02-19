
function setStoreSession( storeId, redriectUrl, baseurl )
{
	/*
	if( ( storeId == '' ) || ( redriectUrl == '' )  )
	{
		return false;
	} */
	if( redriectUrl == '')
	{
		return false;
	}
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/storeSession/'+storeId,
		success:function(msg)
		{
		   
			location.href=redriectUrl;
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ error);	
		}
	});	
}

function setSessionSalesReportDuration( duration, redriectUrl, baseurl )
{
	//alert(duration+redriectUrl+baseurl);
	if( ( duration == '' ) || ( redriectUrl == '' )  )
	{
		return false;
	}
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/salesReportDurationSession/'+duration,
		success:function(msg)
		{
			//alert(JSON.stringify(msg));
			location.href=redriectUrl;
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ error);	
		}
	});	
}

function setSessionConsSalesReport( consId, redriectUrl, baseurl )
{
	if( ( consId == '' ) || ( redriectUrl == '' )  )
	{
		return false;
	}
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/conSalesReportSession/'+consId,
		success:function(msg)
		{
			location.href=redriectUrl;
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ JSON.stringify(error));	
		}
	});	
}


function setSessionIncludePayItems( consId, redriectUrl, baseurl )
{
	/*
	alert(consId);
	alert(redriectUrl);
	alert(baseurl);
	die;
	*/
	if(consId ){
		consId = 1 ;
	}else{
		consId = 0 ;
	}
	if( ( redriectUrl == '' )  )
	{
		return false;
	}
	jQuery.ajax({
		type:'GET',
		url:baseurl+'ajax/conIncludePayItems/'+consId,
		success:function(msg)
		{
			//alert(msg) ;
			location.href=redriectUrl;
			//alert(msg) ;
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ JSON.stringify(error));	
		}
	});	
}


function setCategorySession( catId, redriectUrl, baseurl )
{

	if( ( catId == '' ) || ( redriectUrl == '' )  )
	{
		return false;
	}
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/categorySession/'+catId,
		success:function(msg)
		{
		   
			location.href=redriectUrl;
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ error);	
		}
	});	
}


function setStoreConsultantSession( storeId, redriectUrl, baseurl )
{
	/*
	if( ( storeId == '' ) || ( redriectUrl == '' )  )
	{
		return false;
	}
	*/
	if( redriectUrl == '' )
	{
		return false;
	}
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/storeConsultantSession/'+storeId,
		success:function(msg)
		{
			location.href=redriectUrl;
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ error);	
		}
	});	
}


function setRoleAndUserIdSession( RoleIdAndUserId, redriectUrl, baseurl )
{
    //alert(redriectUrl);
    //alert(baseurl);
    var res = RoleIdAndUserId.split("||||");
    
    var RoleId = res[0];
    var UserId = res[1];
    
    //alert(RoleId);
    //alert(UserId);
    
    if( ( RoleId == '' ) || ( UserId == '' )  )
	{
		return false;
	}
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/storeRoleAndUserIdSession/',
		data:'role_id='+RoleId+'&user_id='+UserId,
		success:function(msg)
		{
		    //alert(msg);
			location.href=redriectUrl;
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ error);	
		}
	});	
}
