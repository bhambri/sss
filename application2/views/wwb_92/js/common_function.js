
baseurl = 'http://localhost/';
function setStoreSession( storeId, redriectUrl )
{
	if( ( storeId == '' ) || ( redriectUrl == '' )  )
	{
		return false;
	}
	
}


function setStoreView(view_type,redriectUrl,baseurl)
{
   
    if( view_type == '')
	{
		return false;

	}
	//alert(view_type+redriectUrl+baseurl);
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/changeView/',
		data:'view_type='+view_type,
		success:function(msg)
		{
		    //alert(msg);
		    location.href=redriectUrl;
		    return false;	
			//alert(msg);		
		},
		error:function(error)
		{
			alert('error is->> '+ error);	
		}
	});	
}

//sortByItem(this.value,'<?php echo $redirectURl ?>','<?php echo base_url() ?>') ;" >Sort By 
function sortByItem(svalue,redriectUrl,baseurl){
	
	if( svalue == '')
	{
		return false;

	}
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/sortBy/',
		data:'sort_by='+svalue,
		success:function(msg)
		{
		    //alert(msg);
			//location.href=redriectUrl;
			window.location.reload();
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ error);	
		}
	});
}

function perPageItem(pvalue,redriectUrl,baseurl){
	if( pvalue == '')
	{
		return false;

	}
	jQuery.ajax({
		type:'POST',
		url:baseurl+'ajax/perPage/',
		data:'per_page='+pvalue,
		success:function(msg)
		{
		    //alert(msg);
			//location.href=redriectUrl;
			window.location.reload();
			return false;			
		},
		error:function(error)
		{
			alert('error is->> '+ error);	
		}
	});
}

function showaccountdiv(){
  jQuery('.account-dropdown').toggle("slow") ;
}
