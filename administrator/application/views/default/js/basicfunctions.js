/***********************************************************************
 * Version 1.0                      
 * WWW: http://www.segnant.com
 * Author: Vince Balrai
 * Creation Date: 13 March, 2010
 ************************************************************************/

function textCounter(fieldname, countfield, maxlimit) {
	if (fieldname.value.length > maxlimit)
		fieldname.value = fieldname.value.substring(0, maxlimit);
	else 
		countfield.value = maxlimit - fieldname.value.length;
}

function bookmark() {
	BrowserDetect.init();
	var browser	 = BrowserDetect.browser;
	netscape=""+browser+" User's hit CTRL+D to add a bookmark to this site.";
	url=window.location.href; // Getting the url of the current page.
	docTitle = document.title; // Getting the title of the current page.
	if (navigator.appName=='Microsoft Internet Explorer') {
		window.external.AddFavorite(url,docTitle);
	} else 
	{
		alert(netscape);
	}
}


function logout(url) {
	if(confirm("Are you sure you want to logout?")){
		window.location.href = url;
	} else {
		return false;
	}
}

var vbst = {
	countryIso: 'US',
	country: null,
	state: null,
	url:null,
	init:function(c, s, u) {
		if((vbst.country = document.getElementById(c)) == null) {
			alert('VBST:DEBUG:: Could not found country element.');
			return false;
		} 
		vbst.countryIso = vbst.country.value;
		if((vbst.state = document.getElementById(s)) == null) {
			alert('VBST:DEBUG:: Could not found state element.');
			return false;
		} 

		if((vbst.url = u).length <= 0) {
			alert('VBST:DEBUG:: Could not found url element.');
			return false;
		}
		
		if(jQuery == null) {
			alert('VBST:DEBUG:: jQuery is required.');
			return false;
		}
		
		vbst.call();
	},
	call: function() {
				
		jQuery.ajax({
			type: 'post',
			data: 'country=' + vbst.countryIso,
			url: vbst.url,
			beforeSend:function() {
				vbst.state.innerHTML = '<img src="../images/ajax-loader.gif" />';
			},
			success:function(data, HTTPStatus, HTTP) {
				vbst.state.innerHTML = data;
			},
			error:function(HTTP, msg, exception) {
				alert("VBST:ERROR:: " + msg + "\n" + exception);
			}
		});
	},
	other:function(s, p) {
		if(s.value == 1) {
			jQuery("#"+p).html("<input type='text' name='" + s.name + "' id='" + s.id +"' maxlength='100' class='inputbox' style='width:150px;' />");
		}
	}
}

var vbdynamicrow = {
	maxallowedrows: 10,
	startcount: 1,
	initialstart: 1,
	init: function(opt) {
		this.startcount = opt.startcount;
		this.initialstart = this.startcount;
		this.addrow(opt.afterrow);
	},
	addrow: function(rowid) {
		
		if(this.startcount > this.maxallowedrows) {
			alert("You have reached the maximum limit.");
			return false;
		}

		var code = '<tr id="rowbefore'+this.startcount+'"><td nowrap="nowrap" class="input_form_caption_td" width="40%">Image: </td><td width="60%" align="left"><input type="file" name="gallery_image[]" id="image" class="inputbox"/>&nbsp;<input type="button" class="button" name="remove" id="remove" value="Remove" onclick="vbdynamicrow.removerow(\'rowafter'+this.startcount+'\', \'rowbefore'+this.startcount+'\')"/>&nbsp;<input type="button" class="button" name="insert" id="insert" value="Insert" onclick="vbdynamicrow.addrow(\'rowafter'+this.startcount+'\')"/><div>[<small>Image dimensions should be 345px x 318px approx.</small>]</div></td></tr><tr id="rowafter'+this.startcount+'"><td nowrap="nowrap" class="input_form_caption_td" width="40%">Thumb Image: </td><td width="60%" align="left"><input type="file" name="gallery_thumb[]" id="thumb_image" class="inputbox"/><div>[<small>Image dimensions should be 94px x 88px approx.</small>]</div></td></tr>';

		jQuery('#'+rowid).after(code);
		this.startcount++;
	},
	removerow: function(aid, bid) {
		
		if(((this.startcount-1) <= 1 && this.maxallowedrows >= 1) || (this.startcount-1) <= this.initialstart ) {
			alert('Can not remove the last row.');
			return false;
		}
		jQuery("#" + aid).empty();
		jQuery("#" + aid).remove();
		jQuery("#" + bid).empty();
		jQuery("#" + bid).remove();
		this.startcount--;
	}
	
}
function checkAll(formid, master) {
	formx = document.getElementById(formid);
	if(master.checked) {
		for(var i=1;i<formx.length;i++) {
			if(formx.elements[i].type=="checkbox") {
				formx.elements[i].checked=true;
			}
		}
	} else {

		for(var i=1;i<formx.length;i++) {
			if(formx.elements[i].type=="checkbox") {
				formx.elements[i].checked=false;
			}
		}
	}

}

function checkMasterState(formid,masterid) {
	formObj = document.getElementById(formid);
	
	status = false;
	
	for(i=1;i<=(formObj.length-1);i++) {
		//alert(formObj.elements[i].id);
		if((formObj.elements[i].type == "checkbox") && (formObj.elements[i].id != masterid)) {
			if(formObj.elements[i].checked != false) {
				status = true;
			}
		}
		//alert('stat'+status) ;
	}
	
	//alert(formid);
	//alert(masterid);
	//document.getElementById(masterid).checked = status;
	document.getElementById(masterid).checked = false;
	//alert('final status'+status);
	
	//jQuery('#'+masterid).attr('checked', status) ;
	//alert(document.getElementById(masterid).checked);
}
function submitListingForm(formid, actionURL, mode,masterId) {
	formObj = document.getElementById(formid);
	elementLength	= formObj.elements.length;
	var ischecked	= false;
	var norecord	= false;
	for(var i=0;i<elementLength;i++) {		//alert(formObj.elements[i].name);		
		if(formObj.elements[i].type == 'checkbox' && formObj.elements[i].name != masterId) {
			if(formObj.elements[i].checked == true  ) {
				ischecked = true;
			}
		}
	}
	if(mode == 'delete') {
		if(ischecked	== true) {
			if(!confirm("Are you sure, you want to proceed for deletion?")) {
				return false;
			}
		} else {			alert("Please Select atleast one checkbox to delete");			return false;		}	}
	if(mode == 'markpaid') {		if(ischecked	== true) {			if(!confirm("Are you sure, you want to proceed for marking paid ?")) {				return false;			}		} else  {			alert("Please Select atleast one checkbox to mark paid");			return false;		}	}		if (mode == 'markread') {		if (ischecked == true) {			if (!confirm("Are you sure, you want to proceed for marking read ?")) {                return false;            }        } else {            alert("Please Select atleast one checkbox to mark read");            return false;        }    }
	formObj.action = actionURL;
	formObj.submit();
}

// Trim Functions 
	function trim(str, chars) {
		return ltrim(rtrim(str, chars), chars);
	}
	 
	function ltrim(str, chars) {
		chars = chars || "\\s";
		return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
	}
	 
	function rtrim(str, chars) {
		chars = chars || "\\s";
		return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
	}

function checkFileFormat(id,allowed) {
	var imgtypes = allowed.split(",");
	var idparts = id.split(":");
	var file = document.getElementById(idparts[0]);

	if(trim(file.value,"") == "") {
		return "The "+ idparts[1] +" field is required. Allowed file types are " + allowed;
	}

	file = file.value.split(".");
	for (var i=0;i<=(imgtypes.length - 1) ;i++ )
	{
		if(file[(file.length - 1)].toLowerCase() == imgtypes[i].toLowerCase()) {
			return null;
		}
	}

	return "The "+ idparts[1] +" field is required. Allowed file types are " + allowed;

}

function validateTinyMCE(id)
{
var textarea = tinyMCE.get(id).getContent(); 
            if ( (textarea=="") || (textarea==null) ) {
                    return "The <b> Description</b> field is required";
            }
			else{
				return null;
			}
}

/*////////////////////////////////////////////////////////
//		Browser Detection.
//////////////////////////////////////////////////////////*/
var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};

/*////////////////////////////////////////////////////////////////*/
