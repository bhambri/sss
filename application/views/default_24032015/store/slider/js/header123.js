var FIXED_RESOLUTION_WIDTH=955;
var FB_USER_INFO_COOKIE="86400";
var saveFBAccessTokenFlag=1;
var overlayViewsArray=new Array();
var anotheraction=0;
var _$=document;
var fbcookieType="";
var unified_registration_is_ldb_user="false";
var unified_registration_ldb_user_pref_id="";
function $(_1){
return ((typeof (_1)=="string")?_$.getElementById(_1):_1);
}
function convertToSlug(_2){
return _2.toLowerCase().replace(/[^\w ]+/g,"").replace(/ +/g,"-");
}
function validateEmail(_3,_4,_5,_6){
if(_3.length==0&&(typeof (_6))&&_6==0){
return true;
}
var _7=/^((([a-z]|[A-Z]|[0-9]|\-|_)+(\.([a-z]|[A-Z]|[0-9]|\-|_)+)*)@((((([a-z]|[A-Z]|[0-9])([a-z]|[A-Z]|[0-9]|\-){0,61}([a-z]|[A-Z]|[0-9])\.))*([a-z]|[A-Z]|[0-9])([a-z]|[A-Z]|[0-9]|\-){0,61}([a-z]|[A-Z]|[0-9])\.)[\w]{2,4}|(((([0-9]){1,3}\.){3}([0-9]){1,3}))|(\[((([0-9]){1,3}\.){3}([0-9]){1,3})\])))$/;
if(_3==""){
return "Please enter your "+_4+".";
}else{
if(!_7.test(_3)){
return "The "+_4+" specified is not correct.";
}
}
return true;
}
function clearMessages(_8,_9,_a){
_9=(typeof (_9)=="undefined")?false:_9;
_a=(typeof (_a)=="undefined")?false:_a;
for(var _b=0;_b<_8.elements.length;_b++){
var _c=_8.elements[_b];
if($(_c.id+"_error")){
$(_c.id+"_error").innerHTML="";
if(_9){
$(_c.id+"_error").parentNode.style.display="none";
}
if(_a){
_c.value="";
}
}
}
}
function setXHRHeaders(_d){
_d.setRequestHeader("Content-length",0);
_d.setRequestHeader("Connection","close");
}
var windowname=null;
function openwindow(_e){
var _f=screen.width*0.8;
var _10=screen.height*0.8;
var _11=(screen.width-_f)/2;
var _12=(screen.height-_10)/2;
var _13="width="+parseInt(screen.width*0.8);
_13+=",height="+parseInt(screen.height*0.8)+",left ="+_11+",top= "+_12;
_13+=",resizable=1,scrollbars=1,toolbar=1,status=1,location=1,directories=1,menubar=1,centerscreen=yes";
if(windowname){
windowname.close();
}
windowname=window.open(_e,"NaukriShiksha",_13);
return false;
}
function getXMLHTTPObject(){
var _14;
try{
_14=new XMLHttpRequest();
}
catch(e){
try{
_14=new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e){
try{
_14=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(e){
alert("Your browser does not support AJAX!");
return false;
}
}
}
return _14;
}
var footerExpandedElement=null;
function toggleMe(obj){
var doc=document;
if(obj.className.indexOf("ftrPSgn")>-1){
doc.getElementById(obj.id.replace("Sign","Container")).className="footerShow";
obj.className="ftrMSgn";
if(footerExpandedElement!=null){
doc.getElementById(footerExpandedElement.id.replace("Sign","Container")).className="footerHide";
footerExpandedElement.className="ftrPSgn";
}
footerExpandedElement=obj;
}else{
doc.getElementById(obj.id.replace("Sign","Container")).className="footerHide";
obj.className="ftrPSgn";
footerExpandedElement=null;
}
}
function trim(str){
try{
if(str&&typeof (str)=="string"){
return str.replace(/^\s*|\s*$/g,"");
}else{
return "";
}
}
catch(e){
return str;
}
}
function getJsonKeyForSearch(val){
return (val.replace(/[^a-zA-Z]*/g,"").toLowerCase());
}
function getCookie(_19){
if(document.cookie.length>0){
c_start=document.cookie.indexOf(_19+"=");
if(c_start!=-1){
c_start=c_start+_19.length+1;
c_end=document.cookie.indexOf(";",c_start);
if(c_end==-1){
c_end=document.cookie.length;
}
return unescape(document.cookie.substring(c_start,c_end));
}
}
return "";
}
function setCookie(_1a,_1b,_1c,_1d){
var _1e=new Date();
_1e.setTime(_1e.getTime());
var _1f=0;
_1c=(typeof (_1c)!="undefined")?_1c:0;
_1d=(typeof (_1d)!="undefined")?_1d:"days";
if(_1c!=0){
if(_1d=="seconds"){
_1c=_1c*1000;
}else{
_1c=_1c*1000*60*60*24;
}
var _20=new Date(_1e.getTime()+(_1c));
var _1f=_20.toGMTString();
document.cookie=_1a+"="+escape(_1b)+";path=/;domain="+COOKIEDOMAIN+""+((_1c==null)?"":";expires="+_1f);
}else{
document.cookie=_1a+"="+escape(_1b)+";path=/;domain="+COOKIEDOMAIN;
}
if(document.cookie==""){
return false;
}
return true;
}
function setClientCookie(){
try{
if(getCookie("client")==""||getCookie("client")==null||document.body.offsetWidth!=getCookie("client")){
if(getCookie("client")!=""&&getCookie("client")!=document.body.offsetWidth&&document.body.offsetWidth>1000&&getCookie("client")<800){
setCookie("client",document.body.offsetWidth,300);
}else{
if(getCookie("client")!=document.body.offsetWidth&&document.body.offsetWidth<1000&&getCookie("client")>1000){
setCookie("client",document.body.offsetWidth,300);
}else{
setCookie("client",document.body.offsetWidth,300);
}
}
if(getCookie("client")==""){
$("enableCookieMsg").style.display="";
$("enableCookieMsg").innerHTML="Cookies are not getting set in your browser! Please Check.";
}
}
}
catch(e){
}
}
function showSubcategories1(_21,_22){
var _23=$("subcategoryDiv1");
_23.style.display="block";
if(_21){
_21=$(_21);
_23.style.top=obtainPostitionY(_21)+"px";
_23.style.left=obtainPostitionX(_21)+(_21.offsetWidth-2)+"px";
if(_22){
var _24=_21.getAttribute("url");
var url=_21.getAttribute("href");
$("subcategoryDivContent1").innerHTML=getSubCategories1(url,_22,_24);
}
}
}
function hideSubcategoties(_26){
_26="subcategoryDiv";
$(_26).style.display="none";
}
function getSubCategories1(url,id,_29){
var _2a="";
var _2b="";
if(url.indexOf("getCategoryPage/colleges")<0){
url+="getCategoryPage/colleges";
}
if(url.indexOf("//"+_29)>0){
url+="/"+_29;
}
for(var _2c=0;_2c<categoryList.length;_2c++){
if(id==categoryList[_2c].parentId){
var _2d=url+"/india/All/"+categoryList[_2c].urlName;
var _2e="<div style=\"margin:5px;\" class=\"quesAnsBullets\"><a href=\""+_2d+"\" title=\""+categoryList[_2c].categoryName+"\">"+categoryList[_2c].categoryName+"</a></div>";
if(categoryList[_2c].categoryName.toLowerCase().indexOf("other")==0){
_2b+=_2e;
}else{
_2a+=_2e;
}
}
}
_2b=_2a+_2b;
return _2b;
}
function obtainPostitionX(_2f){
var x=0;
while(_2f){
x+=_2f.offsetLeft;
_2f=_2f.offsetParent;
}
return x;
}
function obtainPostitionY(_31){
var y=0;
while(_31){
y+=_31.offsetTop;
_31=_31.offsetParent;
}
return y;
}
function openSubDiv(_33,_34){
$("careerOption").style.visibility="hidden";
$("eventTypes").style.visibility="hidden";
$("countryOption").style.visibility="hidden";
$("countries").style.visibility="hidden";
$("testPreparation").style.visibility="hidden";
$("importantDeadlines").style.visibility="hidden";
$("impDeadlines").style.visibility="hidden";
$("eventCategories").style.visibility="hidden";
$("eventCountries").style.visibility="hidden";
var _35=$(_33.id);
var _36=$(_34);
var _37=obtainPostitionY(_35);
var _38=obtainPostitionX(_35);
var _39=_35.offsetWidth;
_36.style.visibility="visible";
_36.style.left=(_38+_39+1)+"px";
_36.style.top=_37+"px";
_36.style.zIndex=500;
setTimeout("overlayHackLayerForIE(\""+_34+"\", $(\""+_34+"\"));",1);
}
function drpdwnOpen(_3a,_3b){
MM_showHideLayers("careerOption","","","hide");
MM_showHideLayers("eventTypes","","","hide");
MM_showHideLayers("countryOption","","","hide");
MM_showHideLayers("countries","","","hide");
MM_showHideLayers("testPreparation","","","hide");
MM_showHideLayers("importantDeadlines","","","hide");
MM_showHideLayers("impDeadlines","","","hide");
MM_showHideLayers("eventCategories","","","hide");
MM_showHideLayers("eventCountries","","","hide");
MM_showHideLayers("cafeOption","","","hide");
MM_showHideLayers("subCatagories","","","hide");
MM_showHideLayers("MBA","","","hide");
var _3c=_3a;
var _3d=$(_3b);
var _3e=obtainPostitionY($("hometab"));
if(_3e==0||_3b=="eventTypes"||_3b=="impDeadlines"){
_3e=obtainPostitionY(_3c);
}
var _3f=obtainPostitionX(_3c);
var _40=_3c.offsetHeight;
_3d.style.left=_3f-1+"px";
_3d.style.top=(_3e+_40-2)+"px";
_3d.style.display="block";
_3d.style.margin="0px";
if((_3f+$(_3b).offsetWidth)>screen.width){
_3f=screen.width-$(_3b).offsetWidth-50;
}
_3d.style.zIndex=1400;
_3d.style.left=_3f-1+"px";
if(_3b=="careerOption"){
var _41=$("subCatagories");
_41.style.left=(320)+"px";
}
setTimeout("overlayHackLayerForIE(\""+_3b+"\", $(\""+_3b+"\"));",1);
$("subCatagories").style.display="none";
$("subCatagories").style.visibility="hidden";
}
function showSubCatagories(_42,_43){
var _44=$("subCatagories");
_44.style.top=(27*_42)+"px";
var _45=20;
var _46=$("catagory_"+_43);
_46.style.background="#FFFFFF";
get_nextsibling($(_46)).style.borderTopColor="#DDDDDD";
_46.style.borderTopColor="#DDDDDD";
_46.style.color="#000";
_44.onmouseover=function(){
_46.style.background="#FFFFFF";
get_nextsibling(_46).style.borderTopColor="#DDDDDD";
_46.style.borderTopColor="#DDDDDD";
_46.style.color="#000";
};
_44.onmouseout=function(){
_46.style.background="#EFF8FF url(\"/public/images/mddwnArw.gif\") no-repeat scroll 94% center";
_46.style.borderTopColor="#A7C9F6";
get_nextsibling(_46).style.borderTopColor="#A7C9F6";
_46.style.color="#0065DE";
};
$(_46).onmouseout=function(){
_46.style.background="#EFF8FF url(\"/public/images/mddwnArw.gif\") no-repeat scroll 94% center";
_46.style.borderTopColor="#A7C9F6";
get_nextsibling(_46).style.borderTopColor="#A7C9F6";
_46.style.color="#0065DE";
};
$("subCourse").innerHTML="";
$("subCat").innerHTML="";
var _47="";
for(var i in tabsContentByCategory[_43]["subcats"]){
var _49=tabsContentByCategory[_43]["subcats"][i];
_47+="<a class=\"shikIcons\" href=\""+_49.url+"\" title=\""+_49.name+" colleges lists\">"+_49.name+"</a>";
_45+=25;
}
if(_47!=""){
_47="Courses"+_47;
$("subCat").innerHTML=_47;
}
var _4a="";
for(var i in tabsContentByCategory[_43]["popcourses"]){
_49=tabsContentByCategory[_43]["popcourses"][i];
_4a+="<a class=\"shikIcons\" href=\""+_49.url+"\" title=\""+_49.name+" colleges lists\">"+_49.name+"</a>";
_45+=25;
}
if(_4a!=""){
$("subCourse").innerHTML="Popular Courses"+_4a;
$("subCourse").style.display="block";
}else{
$("subCourse").style.display="none";
}
if(_45>400){
_45=400;
}
_44.style.height=_45+"px";
_44.style.visibility="visible";
_44.style.display="block";
}
function get_nextsibling(n){
var x=n.nextSibling;
while(x.nodeType!=1){
x=x.nextSibling;
}
return x;
}
function defaultTab(_4d){
var _4e=$(_4d);
var _4f=$("careerOption");
_4f.style.visibility="hidden";
_4e.className="";
objImg=_4e.getElementsByTagName("img");
objImg[0].src="/public/images/mainNavigationArrowWht.gif";
}
function MM_findObj(n,d){
var p,i,x;
if(!d){
d=document;
}
if((p=n.indexOf("?"))>0&&parent.frames.length){
d=parent.frames[n.substring(p+1)].document;
n=n.substring(0,p);
}
if(!(x=d[n])&&d.all){
x=d.all[n];
}
for(i=0;!x&&i<d.forms.length;i++){
x=d.forms[i][n];
}
for(i=0;!x&&d.layers&&i<d.layers.length;i++){
x=MM_findObj(n,d.layers[i].document);
}
if(!x&&d.getElementById){
x=d.getElementById(n);
}
return x;
}
function MM_showHideLayers(){
var i,p,v,obj,_59=MM_showHideLayers.arguments;
for(i=0;i<(_59.length-2);i+=3){
if((obj=MM_findObj(_59[i]))!=null){
v=_59[i+2];
if(obj.style){
obj=obj.style;
v=(v=="show")?"block":"none";
}
obj.display=v;
v=="block"&&_59[0]!="drpDown"?overlayHackLayerForIE(_59[0],$(_59[0])):dissolveOverlayHackForIE();
}
}
}
function overlayHackLayerForIE(_5a,_5b){
overlayHackForIE(_5a,_5b);
}
function overlayHackForIE(_5c,_5d){
var _5e=$("iframe_div");
if(_5e!=null){
var _5f=_5e.style;
if(_5e.getAttribute("container")!=""&&_5e.getAttribute("container")!=_5c&&_5f.display!="none"){
dissolveOverlayHackForIE();
}
_5e.setAttribute("container",_5c);
_5e.container=_5c;
_5f.display="block";
_5f.width=_5d.offsetWidth+"px";
_5f.height=_5d.offsetHeight+"px";
_5f.top=obtainPostitionY(_5d)+"px";
_5f.left=obtainPostitionX(_5d)+"px";
if($(_5c).style.zIndex!=0||$(_5c).style.zIndex!=""){
_5f.zIndex=parseInt($(_5c).style.zIndex)-1;
}else{
_5f.zIndex=1000;
}
}
}
function dissolveOverlayHackForIE(){
if($("iframe_div")){
try{
if($($("iframe_div").getAttribute("container"))){
$($("iframe_div").getAttribute("container")).style.display="none";
}
}
catch(e){
}
$("iframe_div").style.display="none";
}
}
var bannerPool=new Array();
function pushBannerToPool(_60,_61){
if(_60!=""){
bannerPool[_60]=_61;
}
}
function checkTextElementOnTransition(_62,_63){
var _64=trim(_62.getAttribute("default"));
if(_64==null){
return false;
}
if(_63=="focus"){
_62.style.color="";
if(trim(_62.value)==_64){
if(_62.type.toLowerCase()=="password"){
_62.className=_62.className.replace("passwordTxt","");
return;
}
_62.value="";
}
}else{
if(trim(_62.value)==""){
if(_62.type.toLowerCase()=="password"){
_62.className+=" passwordTxt";
return;
}
_62.value=_64;
_62.style.color="#ada6ad";
}
}
}
function validateLoginForHeader(_65){
if((_65.password_header.value=="")||(_65.username_header.value=="")||_65.username_header.getAttribute("default")==_65.username_header.value){
return false;
}
var _66=$("username_header");
var _67=$("password_header");
_66.className=_66.className.replace("error_box","");
_67.className=_67.className.replace("error_box","");
clearMessages(_65,true);
var _68=validateEmail(_65.username_header.value,"email address",125,10);
if(_68!=true){
_66.className+=" error_box";
_67.className+=" error_box";
showCommonInlineErrorMessage("username_header",_68);
}else{
$("mpassword_header").value=hex_md5($("password_header").value);
}
return true;
}
function showCommonInlineErrorMessage(_69,_6a){
if($(_69+"_error")){
$(_69+"_error").parentNode.style.display="inline";
$(_69+"_error").innerHTML=_6a;
}
return;
}
function showLoginResponseForHeader(str){
var _6c=$("username_header");
var _6d=$("password_header");
_6c.className=_6c.className.replace("error_box","");
_6d.className=_6d.className.replace("error_box","");
var _6e;
if(str==0){
_6e="Incorrect account details. Please enter Login Email Id & Password again.";
}
if(str=="invalid"){
_6e="The login email you have provided is not valid. This account has been disabled.";
}
if(str==0||str=="invalid"){
_6c.className+=" error_box";
_6d.className+=" error_box";
showErrorMessageForAnAReg("username_header",_6e);
return false;
}
if(Number(str)>0){
window.location.reload();
}
return;
}
function selectTab(_6f,_70,_71,_72){
var _73=getElementsByAttributeName(_6f.parentNode,"tab");
var _74=$(_70);
var _75=getElementsByAttributeName(_74.parentNode,"tabContent");
for(var _76=0,tab;tab=_73[_76];_76++){
tab.className=tab.className.replace(_71,"").concat(" "+_72);
_75[_76].style.display="none";
}
_6f.className=_6f.className.replace(_72,"").concat(" "+_71);
_74.style.display="";
return false;
}
function getElementsByAttributeName(_78,_79,_7a){
var _7b,_7c,_7d=new Array(),_7e=0;
if(_7a){
_7b=_78.getElementsByTagName(_7a);
}else{
_7b=_78.childNodes;
}
while(_7c=_7b[_7e++]){
if(_7c&&_7c.nodeType==1&&_7c.getAttribute(_79)){
_7d.push(_7c);
}
}
return _7d;
}
function glider(_7f,_80,_81,_82){
this.gliderCodeRunning=0;
this.noOfInterval=(typeof (_81)=="undefined")?10:_81;
this.timeForGliding=(typeof (_82)=="undefined")?500:_82;
try{
var _83=this.getFirstLevelChilds(_7f);
var _84=_83[0].offsetWidth;
_7f.parentNode.style.width=_84+"px";
for(var i=0;i<_83.length;i++){
_83[i].style.width=_84+"px";
_83[i].innerHTML+="&nbsp;";
if(i==_80){
this.changeFirstDivChild(_83[i],"");
}else{
this.changeFirstDivChild(_83[i],"none");
}
}
_7f.style.width=((_83.length*_84)+50)+"px";
_7f.style.left=(Number(_80)*Number(_84)*(-1))+"px";
}
catch(e){
}
return;
}
glider.prototype.setWidthOfParentDiv=function(_86,_87,_88){
var _89=this.getFirstLevelChilds(_86);
_86.style.width=(((_89.length+_88)*_87)+50)+"px";
return;
};
glider.prototype.setLeftPosition=function(_8a,_8b,_8c,_8d){
if((_8b<0)&&(_8c<0)){
_8a.style.left=(_8c*_8d)+"px";
}
if((_8b>0)&&(_8c<0)){
_8a.style.left=(-(_8a.offsetWidth-_8d-50))+"px";
}
return;
};
glider.prototype.checkLimits=function(_8e,_8f,_90){
var _91=false;
if(((this.getNumVal(_8e.style.width)-50)==Math.abs(this.getNumVal(_8e.style.left)-Number(_90)))&&(_8f>0)){
_91="upper";
}else{
if((this.getNumVal(_8e.style.left)==0)&&(_8f<0)){
_91="lower";
}
}
return _91;
};
glider.prototype.getNumVal=function(_92){
return Number(_92.substring(0,(_92.length-2)));
};
glider.prototype.slideIt=function(_93,_94,_95,_96){
if(this.gliderCodeRunning==1){
return false;
}
var _97=$(_93);
var _96=(typeof (_96)=="undefined")?0:_96;
var _98=this.getFirstLevelChilds(_97);
var _99=_98[0].offsetWidth;
this.setLeftPosition(_97,_94,_96,_99);
var _9a=_97.getAttribute("currentShownDiv");
var _9b=$(_93+_9a);
_9a=parseInt(_9a)+_94;
var _9c=this.checkLimits(_97,_94,_99);
if(_9c!=false){
if(!_95){
return false;
}else{
if(_9c=="upper"){
this.changeFirstDivChild(_98[0],"");
_97.style.left="0px";
this.changeFirstDivChild(_98[_98.length-1],"none");
var _9d=_98[0].getAttribute("divNumber");
}else{
this.changeFirstDivChild(_98[_98.length-1],"");
_97.style.left=-(gliderObject.getNumVal(_97.style.width)-_99-50)+"px";
this.changeFirstDivChild(_98[0],"none");
var _9d=_98[_98.length-1].getAttribute("divNumber");
}
_97.setAttribute("currentShownDiv",_9d);
return false;
}
}
_97.setAttribute("currentShownDiv",_9a);
this.changeFirstDivChild($(_93+_9a),"");
this.gliderCodeRunning=1;
this.alterWithInterval(_97,_9b,_94);
return;
};
glider.prototype.changeFirstDivChild=function(_9e,_9f){
_9e.getElementsByTagName("div")[0].style.display=_9f;
return;
};
glider.prototype.alterWithInterval=function(_a0,_a1,_a2){
var _a3=this.getNumVal(_a1.style.width);
var _a4=(_a3/this.noOfInterval)*_a2;
var _a5=this.getNumVal(_a0.style.left);
var _a6=_a5-(_a3*_a2);
var _a7=this;
var _a8=0;
var _a9=setInterval(function(){
_a5=_a5-_a4;
_a0.style.left=(_a5)+"px";
_a8++;
if(_a8>=_a7.noOfInterval){
_a0.style.left=(_a6)+"px";
clearInterval(_a9);
_a7.gliderCodeRunning=0;
_a7.changeFirstDivChild(_a1,"none");
}
},(_a7.timeForGliding/_a7.noOfInterval));
return;
};
glider.prototype.getFirstLevelChilds=function(_aa){
var _ab=_aa.childNodes;
var _ac=_aa.id;
var _ad=new Array();
for(var i=0;i<_ab.length;i++){
if((_ab[i].nodeType==1)&&(_ab[i].id.indexOf(_ac)!=-1)){
_ad.push(_ab[i]);
}
}
return _ad;
};
function hideOverlay(_af){
_af=(typeof (_af)!="undefined")?_af:true;
if(typeof isUserLoggedIn!="undefined"&&!isUserLoggedIn&&getCookie("user")!=""&&(anotheraction==0)&&(_af)){
window.location.reload();
}else{
dissolveOverlayHackForIE();
$("genOverlay").style.display="none";
$("dim_bg").style.display="none";
$("overlayCloseCross").className="";
if(($("genOverlayContents").innerHTML!="")&&(overlayParent)){
if(typeof (overlayContent)!="undefined"){
overlayParent.innerHTML=overlayContent;
}else{
overlayParent.innerHTML=$("genOverlayContents").innerHTML;
}
}
$("genOverlayContents").innerHTML="";
}
}
var h=document.documentElement.scrollTop;
function setScroll(x,y){
h=document.documentElement.scrollTop;
window.scrollTo(x,y);
window.onscroll=function(){
h=document.documentElement.scrollTop;
window.scrollTo(x,y);
};
}
function setNoScroll(){
window.scrollTo(0,h);
window.onscroll=function(){
};
}
var overlayParent;
function showOverlay(_b2,_b3,_b4,_b5,_b6,_b7,top){
if(trim(_b5)==""){
return false;
}
var _b9=document.getElementsByTagName("body")[0];
$("overlayTitle").innerHTML=_b4;
if(trim(_b4)==""){
$("overlayTitle").parentNode.style.display="none";
}else{
$("overlayTitle").parentNode.style.display="";
}
$("genOverlay").style.width=_b2+"px";
$("genOverlay").style.height=_b3+"px";
$("genOverlayContents").innerHTML=_b5;
var _ba=parseInt(screen.height)/2;
var _bb;
if(typeof _b7!="undefined"){
_bb=_b7;
}else{
_bb=(parseInt(_b9.offsetWidth)/2)-(_b2/2);
}
if(typeof top!="undefined"){
_ba=top;
}else{
_ba=parseInt(_ba-parseInt(_b3/2))-70;
}
h=document.body.scrollTop;
var h1=document.documentElement.scrollTop;
h=h1>h?h1:h;
_ba=_ba+h;
if(typeof _b6=="undefined"||_b6===false){
$("dim_bg").style.height=_b9.scrollHeight+"px";
$("dim_bg").style.display="inline";
if($("dim_bg").offsetWidth<_b9.offsetWidth){
$("dim_bg").style.width=_b9.offsetWidth+"px";
}
}
if($("genOverlay").scrollHeight<_b9.offsetHeight){
$("genOverlay").style.left=_bb+"px";
$("genOverlay").style.top=_ba+"px";
}else{
$("genOverlay").style.left=_bb+"px";
$("genOverlay").style.top="100px";
$("dim_bg").style.height=($("genOverlay").scrollHeight+100)+"px";
window.scrollTo(_bb,"100");
}
overlayHackLayerForIE("genOverlay",_b9);
$("overlayCloseCross").className="cssSprite1 allShikCloseBtn";
$("genOverlay").style.display="inline";
}
if(typeof autoCompleteFlag=="undefined"){
var Ajax={getParams:function(_bd,_be){
if(_bd==null||typeof _bd=="undefined"){
return null;
}
var _bf=_bd.split("&");
var _c0=null;
if(_bf!=null){
for(var _c1=0;_c1<_bf.length;_c1++){
var _c2=_bf[_c1].split("=");
_c0=_c0==null?"":_c0;
var _c3=_c2[1];
if(trim(_c2[1]).split(" ").length!=1){
var _c3=encodeURIComponent(_c2[1]);
}
_c0+=_c0==""?_c2[0]+"="+_c3:"&"+_c2[0]+"="+_c3;
}
}
_be.setRequestHeader("Content-type","application/x-www-form-urlencoded");
_be.setRequestHeader("Content-length",_c0.length);
_be.setRequestHeader("Connection","close");
return _c0;
},Request:function(url,_c5){
if(_c5!=null&&typeof _c5!="undefined"){
if(typeof (_c5["onBeforeAjax"])!="undefined"){
_c5["onBeforeAjax"].call(this,_c6);
}
}
var _c6=getXMLHTTPObject();
_c6.onreadystatechange=function(){
if(_c6.readyState==4){
if(_c5!=null&&typeof _c5!="undefined"){
if(typeof (_c5["onComplete"])!="undefined"&&_c5["onComplete"]!=null){
try{
_c5["onComplete"].apply(this,_c6);
}
catch(e){
_c5["onComplete"].call();
}
}
if(typeof (_c5["onSuccess"])=="undefined"||_c5["onSuccess"]==null){
_c5["onSuccess"]=new function(){
return true;
};
}
if(typeof (_c5["onFailure"])=="undefined"||_c5["onFailure"]==null){
_c5["onFailure"]=new function(){
return false;
};
}
}
try{
(_c6.status==200)?_c5["onSuccess"].call(this,_c6):_c5["onFailure"].call(this,_c6);
}
catch(e){
}
}
};
var _c7=null;
if(_c5!=null&&typeof _c5!="undefined"){
_c7=_c5.method;
}
_c7=_c7!=null?_c7:"POST";
_c6.open(_c7,url,true);
var _c8=typeof _c5=="undefined"||_c5==null||typeof _c5.parameters=="undefined"?null:Ajax.getParams(_c5.parameters,_c6);
_c6.send(_c8);
},Updater:function(_c9,url,_cb){
if(_cb!=null&&typeof _cb!="undefined"){
if(typeof (_cb["onBeforeAjax"])!="undefined"){
_cb["onBeforeAjax"].call(this,_cc);
}
}
var _cc=getXMLHTTPObject();
_cc.onreadystatechange=function(){
if(_cc.readyState==4){
try{
if(_cc.status==200){
$(_c9).innerHTML=_cc.responseText;
if(typeof (_cb["onSuccess"])!="undefined"&&_cb["onSuccess"]!=null){
_cb["onSuccess"].call(this,_cc);
}
if(typeof (_cb["onFailure"])!="undefined"&&_cb["onFailure"]!=null){
_cb["onFailure"].call(this,_cc);
}
}
}
catch(e){
}
if(_cb!=null&&typeof _cb!="undefined"){
if(typeof (_cb["onComplete"])!="undefined"&&_cb["onComplete"]!=null){
_cb["onComplete"].apply(this,this.xmlHttp);
}
}
return true;
}
};
var _cd=null;
if(_cb!=null&&typeof _cb!="undefined"){
_cd=_cb.method;
}
_cd=_cd!=null?_cd:"POST";
_cc.open(_cd,url,true);
var _ce=typeof _cb=="undefined"||_cb==null||typeof _cb.parameters=="undefined"?null:Ajax.getParams(_cb.parameters,_cc);
_cc.send(_ce);
}};
Object.extend=function(_cf,_d0){
for(var _d1 in _d0){
_cf[_d1]=_d0[_d1];
}
return _cf;
};
Object.extend(Object,{isString:function(_d2){
return typeof _d2=="string";
}});
var Form={reset:function(_d3){
$(_d3).reset();
return _d3;
},serialize:function(_d4){
if(typeof _d4=="string"){
_d4=$(_d4);
}
var _d5=_d4.elements;
var _d6="";
for(var _d7=0,_d8;_d8=_d5[_d7];_d7++){
if(_d8.name==null||_d8.name==""){
continue;
}
if((_d8.type=="radio"||_d8.type=="checkbox")&&(!_d8.checked)){
continue;
}
if(_d6!=""){
_d6+="&";
}
_d6+=_d8.name+"="+encodeURIComponent(_d8.value);
}
return _d6;
}};
}
function getEducationLevel(id,Edu,_db,_dc){
var _dd=$(id);
_db=!_db?false:_db;
if(createEduDropDown(EduList["2"],_dd,_db,Edu,_dc)){
}
}
var currentDiv=2;
function showCourseMapDiv(){
if(currentDiv>=5){
$("courseMapAdd").style.display="none";
}
$("courseMapDiv_"+currentDiv).style.display="block";
currentDiv++;
}
function setValue(id,obj){
document.getElementById(id).value=obj.value;
}
function getCoursesForCategory(_e0,i){
var _e2=$("courseMap");
var _e3=$("categoryMap");
if(typeof (_e0)=="undefined"){
_e0=_e3.value;
}
if(_e0!=0){
var _e4="categoryId="+_e0+"&id="+i;
var url=SITE_URL+"enterprise/ShowForms/getCourses";
new Ajax.Request(url,{method:"post",parameters:(_e4),onSuccess:function(_e6){
var _e7=_e6.responseText;
$("courseListSpan_"+i).innerHTML=_e7;
}});
}else{
$("courseListSpan_"+i).innerHTML="<select name='courseMap_"+i+"' id='courseMap' class='sLSel' style='width: 180px;'><option value='0'>Select Course</option></select>";
}
}
function createDropDown(_e8,_e9,_ea){
var _eb=0;
if(_e8){
_eb=_e8.length;
}
if(_eb==0){
_e9.style.display="none";
$("zonewala").style.display="none";
}else{
_e9.style.display="";
if($("locality")!=null){
$("locality").disabled="true";
}
$("zonewala").style.display="";
}
_e9.innerHTML="";
var _ec=document.createElement("option");
_ec.value="";
_ec.innerHTML="Select";
_ec.title="Select";
_e9.appendChild(_ec);
for(var _ed in _e8){
_ec=document.createElement("option");
_ec.value=_ed;
_ec.innerHTML=_e8[_ed];
_ec.title=_e8[_ed];
_e9.appendChild(_ec);
}
if(_ea){
_ec=document.createElement("option");
_ec.value="Others";
_ec.innerHTML="Others";
_ec.title="Others";
_e9.appendChild(_ec);
}
return true;
}
function selectLocality(_ee){
for(var i=0;i<_ee.length;i++){
if(_ee.options[i].selected==true){
var _f0=_ee.options[i].text;
}
}
if(_f0=="Select"){
return;
}
if(_f0=="Others"){
$("locality").value="";
if(!otherLocalityShown){
var _f1=document.createElement("input");
_f1.name="user_added_locality_name";
_f1.id="user_added_locality_name";
_f1.setAttribute("tip","others");
_f1.setAttribute("required","true");
_f1.setAttribute("minLength","1");
_f1.setAttribute("maxLength","50");
_f1.setAttribute("validate","validateStr");
_f1.setAttribute("profanity","true");
_f1.setAttribute("caption","Locality");
_f1.setAttribute("autocomplete","off");
if(_f1.addEventListener){
_f1.addEventListener("change",changeLocality,true);
}else{
_f1.attachEvent("onchange",changeLocality);
}
$("user_locality_div").appendChild(_f1);
otherLocalityShown=true;
}
try{
$("user_added_locality_name").style.display="";
$("user_added_locality_name").addEventListener("change",changeLocality,false);
}
catch(err){
}
}else{
$("locality").value=_f0;
try{
$("user_added_locality_name").style.display="none";
$("user_added_locality_name").value="";
}
catch(err){
}
$("locality").value=_f0;
$("locality_name").value=_f0;
}
}
function changeLocality(){
var _f2=$("user_added_locality_name").value;
$("locality").value=_f2;
$("locality_name").value=_f2;
}
function changeLocality1(){
try{
var _ef=$("locality").value;
$("locality_name").value=_ef;
$("user_added_locality_name").style.display="none";
$("user_added_locality_name").value="";
}
catch(err){
}
}
function getZonesForCity(_f4){
var _f5=$("zone");
var _f6=$("cities");
if(typeof (_f4)=="undefined"){
_f4=_f6.value;
}
var _f7=zoneList[_f4];
$("locality").value="";
createDropDown(_f7,_f5);
for(var i=0;i<_f6.length;i++){
if(_f6.options[i].selected==true){
var _f9=_f6.options[i].text;
}
}
$("city").value=_f9;
$("city_name").value=_f9;
$("city").disabled=true;
}
function prefillZoneList(_fa,_fb){
var _fc=zoneList[_fa];
var _fd=$("zone");
createDropDown(_fc,_fd);
for(var i=0;i<_fd.length;i++){
if(_fd[i].value==_fb){
_fd[i].selected="selected";
}
}
}
function prefillLocalityList(_ff,_100){
var _101=localityList[_ff];
var _102=$("localities");
createDropDown(_101,_102,true);
for(var i=0;i<_102.length;i++){
if(_102[i].value==_100){
_102[i].selected="selected";
}
}
}
function getLocalitiesForZone(_104){
var _105=$("localities");
_105.disabled=false;
zoneId=_104.value;
var _106=localityList[zoneId];
createDropDown(_106,_105,true);
}
function clearLocality(){
$("zonewala").style.display="none";
$("locality").value="";
$("city").value="";
}
function clearLocality1(){
$("localities").selectedIndex=0;
$("locality").removeAttribute("disabled");
if($("locality_name").value.length>0){
$("locality_name").value="";
}
}
function getCitiesForCountry(_107,_108,_109,_10a){
if((typeof (_109)!="undefined")&&(trim(_109)!="")){
var _10b=$("cities"+_109);
if($("country"+_109)){
var _10c=$("country"+_109).value;
}
}else{
_109="";
var _10b=$("cities");
var _10c=$("country").value;
}
if(typeof (_107)=="undefined"){
_107=_10b.value;
}
_108=!_108?false:_108;
_10a=_10a=="undefined"?true:_10a;
var _10d=_10b.getAttribute("unrestricted");
if(_10d!==null){
var _10e=unRestrictedCityList[_10c];
}else{
var _10e=cityList[_10c];
}
if(createCityDropDown(_10e,_10b,_108,_10a)){
if(_107==""){
_107=_10b.value;
}
selectComboBox(_10b,_107);
checkCity(_10b,"checkInstitute",_107,_109);
}
}
function createEduDropDown(_10f,_110,_111,Edu,from){
var _114=0;
if(_10f){
_114=_114.length;
}
_110.innerHTML="";
var _115=document.createElement("option");
_115.value="";
if((_111==true)||(_111==1)){
_115.innerHTML="Select";
_115.title="Select";
}
_110.appendChild(_115);
if(from=="reqInfo"){
_115=document.createElement("option");
_115.innerHTML="School Student";
_115.title="School";
_115.value="School";
_110.appendChild(_115);
}
var i=0;
for(var Edu in _10f){
_115=document.createElement("option");
_115.value=Edu;
_115.innerHTML=getSmString(_10f[Edu],30);
_115.title=_10f[Edu];
_110.appendChild(_115);
i++;
}
var _117="";
if(Edu!=""){
var _115=document.createElement("option");
_115.value="Other";
_115.innerHTML="Other";
_115.title="Other";
_110.appendChild(_115);
_117=$(Edu);
}
_110.style.display="inline";
return true;
}
function checkInstitute(_118,_119,_11a){
var _11b="courses";
if((typeof (_11a)!="undefined")&&(trim(_11a)!="")){
_11b="courses"+_11a;
}
if(!_118){
return false;
}
var _11c=$(_118.id+"_other");
if(_118.value=="-1"){
showElement(_11c);
}else{
hideElement(_11c);
}
getCoursesForInstitute(_11a);
if((typeof (_119)!="undefined")&&(_119!="")){
if(_118){
eval(_119+"(\""+_118.value+"\",\""+_11b+"\")");
}else{
eval(_119+"("+_118.value+")");
}
}
}
function getInstitutesForCity(_11d){
var _11e="colleges";
var _11f="cities";
if((typeof (_11d)!="undefined")&&(trim(_11d)!="")){
_11e="colleges"+_11d;
_11f="cities"+_11d;
}
if($(_11e)){
var _120=$(_11e);
var _121=$(_11f).value;
var _122=getXMLHTTPObject();
_122.onreadystatechange=function(){
if(_122.readyState==4){
var _123=eval("eval("+_122.responseText+")");
if(createInstituteDropDown(_123,_120)){
checkInstitute(_120,"updateInstitutes",_11d);
}else{
checkInstitute(_120,"updateInstitutes",_11d);
}
}
};
if(_121==""){
return false;
}
var url="/rating/Rating/getInstitutesForCity/1/"+_121+"/"+randNum();
_122.open("POST",url,true);
_122.setRequestHeader("Content-length",0);
_122.setRequestHeader("Connection","close");
_122.send(null);
}
}
function checkCity(_125,_126,_127,_128){
var _129="country";
var _12a;
if($("localities")){
$("localities").disabled=true;
}
if((typeof (_128)!="undefined")&&(trim(_128)!="")){
_129="country"+_128;
}
var _12b=$(_125.id+"_other");
if(_12b){
_12b.value="";
if(_125[_125.selectedIndex].text=="Others"){
showElement(_12b);
_12a=_12b.value;
}else{
hideElement(_12b);
$("cities_other_error").parentNode.style.display="none";
_12a=_125[_125.selectedIndex].text;
}
}else{
_12a=_125[_125.selectedIndex].text;
}
if(_127==""){
_127=_125.value;
}
if((typeof (_127)!="undefined")&&(_127!="")){
createLocationCrumb($(_129),_12a,_127,_125);
}
getInstitutesForCity(_128);
if(typeof (_126)!="undefined"&&_126!=""){
var temp=_126+"("+_125.value+")";
eval(temp);
}
}
function selectComboBox(_12d,_12e){
try{
for(var i=0;i<_12d.options.length;i++){
_12d.options[i].removeAttribute("selected");
if(_12d.options[i].value==_12e){
_12d.options[i].setAttribute("selected",true);
_12d.options[i].selected=true;
}
}
}
catch(e){
}
return true;
}
function getSmString(str,len){
if(str.length>len){
return str.substring(0,len-3)+"...";
}else{
return str;
}
}
function createCityDropDown(_132,_133,_134,_135){
var _136=0;
if(_132){
_136=_132.length;
}
_133.innerHTML="";
var _137=document.createElement("option");
_137.value="";
if((_134==true)||(_134==1)){
_137.innerHTML="All Cities";
_137.title="All Cities";
}else{
_137.innerHTML="Select City";
_137.title="Select City";
}
_133.appendChild(_137);
for(var city in _132){
_137=document.createElement("option");
_137.value=city;
_137.innerHTML=getSmString(_132[city],30);
_137.title=_132[city];
_133.appendChild(_137);
}
if(!_134&&_135==true){
var _137=document.createElement("option");
_137.value=-1;
_137.innerHTML="Other";
_137.title="Other";
_133.appendChild(_137);
}
var _139=$(_133.id+"_other");
if(_136===0){
_133.style.display="none";
if(_139){
_139.style.display="inline";
}
updateInstitutes(-1,_133.id);
return false;
}else{
_133.style.display="inline";
if(_139){
_139.style.display="none";
}
return true;
}
}
function checkViewDDs(_13a){
if($("countOffset_DD1")){
if(parseInt($("countOffset_DD1").options[0].value)>=_13a){
if($("countOffset_DD1")){
$("countOffset_DD1").parentNode.style.display="none";
}
if($("countOffset_DD2")){
$("countOffset_DD2").parentNode.style.display="none";
}
}else{
if($("countOffset_DD1")){
$("countOffset_DD1").parentNode.style.display="inline";
}
if($("countOffset_DD2")){
$("countOffset_DD2").parentNode.style.display="inline";
}
}
}
}
function doPagination(_13b,_13c,_13d,_13e,_13f,_140,_141){
checkViewDDs(_13b);
if(!_141){
_141=10;
}
_13c=typeof (_13c)!="undefined"?_13c:"startOffSet";
_13d=typeof (_13d)!="undefined"?_13d:"countOffset";
count=_13d;
_13e=typeof (_13e)!="undefined"?_13e:"paginataionPlace1";
_13f=typeof (_13f)!="undefined"?_13f:"paginataionPlace2";
_140=typeof (_140)!="undefined"?_140:"methodName";
_13d=parseInt($(_13d).value);
if(_13d<1){
_13d=15;
}
var _142=parseInt($(_13c).value);
var _143=getPaginationHtml(_13b,_13c,_13d,_142,_140,_141);
if($(_13e)){
$(_13e).innerHTML=_143;
}
if($(_13f)){
$(_13f).innerHTML=_143;
}
}
function getPageNumbers(_144,_145,_146,_147,_148){
var _149="";
var _14a=_144>=_146/2?(_144-Math.floor(_146/2)):0;
if(_14a+_146>_145){
_14a=(_145-_146);
}
if(_14a<0){
_14a=0;
}
for(;0<_146;_146--,_14a++){
if(_145<_14a+1){
break;
}
if(_144==_14a){
_149+="<a href=\"#\" class=\"show\" onclick=\"return false;\">"+(_14a+1)+"</a> ";
}else{
_149+="<a href=\"#\" onClick=\"return updateStartOffset("+(_14a)+",'"+_147+"','"+count+"','"+_148+"')\">"+(_14a+1)+"</a> ";
}
}
return _149;
}
function getPaginationHtml(_14b,_14c,_14d,_14e,_14f,_150){
var _151="";
var _152=Math.ceil(_14b/_14d);
var _153=Math.ceil(_14e/_14d);
var _154="<span id=\"pageNumbers\">";
_154+=getPageNumbers(_153,_152,_150,_14c,_14f);
_154+="</span>";
if(_152<1){
}else{
if(_152==1){
}else{
_151+="<span class=\"normaltxt_11p_blk fontSize_12p\"> &nbsp;</span>";
if(_153==0){
}else{
_151+="<a href=\"#\" onClick=\"return updateStartOffset("+(parseInt(_153)-1)+",'"+_14c+"','"+count+"','"+_14f+"')\">Prev</a>";
}
_151+=_154;
if(_153==_152-1){
}else{
_151+="<a href=\"#\" onClick=\"return updateStartOffset("+(parseInt(_153)+1)+",'"+_14c+"','"+count+"','"+_14f+"')\">Next</a>";
}
}
}
return _151;
}
function updateStartOffset(_155,_156,_157,_158,_159){
_159=(typeof (_159)=="undefined")?true:_159;
setStartOffset(_155,_156,_157);
if(_159){
changePage(_158);
}
return false;
}
function setStartOffset(_15a,_15b,_15c){
_15b=typeof (_15b)!="undefined"?_15b:"startOffSet";
_15c=typeof (_15c)!="undefined"?_15c:"countOffset";
$(_15b).value=(parseInt(_15a)*parseInt($(_15c).value));
}
function updateCountOffset(_15d,_15e,_15f,_160,_161){
_15e=(typeof (_15e)=="undefined")?"startOffSet":_15e;
_15f=(typeof (_15f)=="undefined")?"countOffset":_15f;
_161=(typeof (_161)=="undefined")?true:_161;
var _162=parseInt($(_15f).value);
var _163=parseInt($(_15e).value);
$(_15f).value=_15d.value;
selectComboBox($("countOffset_DD1"),_15d.value);
selectComboBox($("countOffset_DD2"),_15d.value);
if(_163==0||_163<_15d.value){
updateStartOffset(0,_15e,_15f,_160,_161);
}else{
updateStartOffset(Math.floor(_163/_15d.value),_15e,_15f,_160,_161);
}
}
function changePage(_164){
var _164=typeof (_164)!="undefined"?_164:"methodName";
var _165=$(_164).value;
window[_165]();
}
function updatePaginationMethodName(_166,_167){
_167=typeof (_167)!="undefined"?_167:"methodName";
$(_167).value=_166;
}
var hexcase=0;
var b64pad="";
var chrsz=8;
function hex_md5(s){
return binl2hex(core_md5(str2binl(s),s.length*chrsz));
}
function binl2hex(_4c){
var _4d=hexcase?"0123456789ABCDEF":"0123456789abcdef";
var str="";
for(var i=0;i<_4c.length*4;i++){
str+=_4d.charAt((_4c[i>>2]>>((i%4)*8+4))&15)+_4d.charAt((_4c[i>>2]>>((i%4)*8))&15);
}
return str;
}
function core_md5(x,_b){
x[_b>>5]|=128<<((_b)%32);
x[(((_b+64)>>>9)<<4)+14]=_b;
var a=1732584193;
var b=-271733879;
var c=-1732584194;
var d=271733878;
for(var i=0;i<x.length;i+=16){
var _11=a;
var _12=b;
var _13=c;
var _14=d;
a=md5_ff(a,b,c,d,x[i+0],7,-680876936);
d=md5_ff(d,a,b,c,x[i+1],12,-389564586);
c=md5_ff(c,d,a,b,x[i+2],17,606105819);
b=md5_ff(b,c,d,a,x[i+3],22,-1044525330);
a=md5_ff(a,b,c,d,x[i+4],7,-176418897);
d=md5_ff(d,a,b,c,x[i+5],12,1200080426);
c=md5_ff(c,d,a,b,x[i+6],17,-1473231341);
b=md5_ff(b,c,d,a,x[i+7],22,-45705983);
a=md5_ff(a,b,c,d,x[i+8],7,1770035416);
d=md5_ff(d,a,b,c,x[i+9],12,-1958414417);
c=md5_ff(c,d,a,b,x[i+10],17,-42063);
b=md5_ff(b,c,d,a,x[i+11],22,-1990404162);
a=md5_ff(a,b,c,d,x[i+12],7,1804603682);
d=md5_ff(d,a,b,c,x[i+13],12,-40341101);
c=md5_ff(c,d,a,b,x[i+14],17,-1502002290);
b=md5_ff(b,c,d,a,x[i+15],22,1236535329);
a=md5_gg(a,b,c,d,x[i+1],5,-165796510);
d=md5_gg(d,a,b,c,x[i+6],9,-1069501632);
c=md5_gg(c,d,a,b,x[i+11],14,643717713);
b=md5_gg(b,c,d,a,x[i+0],20,-373897302);
a=md5_gg(a,b,c,d,x[i+5],5,-701558691);
d=md5_gg(d,a,b,c,x[i+10],9,38016083);
c=md5_gg(c,d,a,b,x[i+15],14,-660478335);
b=md5_gg(b,c,d,a,x[i+4],20,-405537848);
a=md5_gg(a,b,c,d,x[i+9],5,568446438);
d=md5_gg(d,a,b,c,x[i+14],9,-1019803690);
c=md5_gg(c,d,a,b,x[i+3],14,-187363961);
b=md5_gg(b,c,d,a,x[i+8],20,1163531501);
a=md5_gg(a,b,c,d,x[i+13],5,-1444681467);
d=md5_gg(d,a,b,c,x[i+2],9,-51403784);
c=md5_gg(c,d,a,b,x[i+7],14,1735328473);
b=md5_gg(b,c,d,a,x[i+12],20,-1926607734);
a=md5_hh(a,b,c,d,x[i+5],4,-378558);
d=md5_hh(d,a,b,c,x[i+8],11,-2022574463);
c=md5_hh(c,d,a,b,x[i+11],16,1839030562);
b=md5_hh(b,c,d,a,x[i+14],23,-35309556);
a=md5_hh(a,b,c,d,x[i+1],4,-1530992060);
d=md5_hh(d,a,b,c,x[i+4],11,1272893353);
c=md5_hh(c,d,a,b,x[i+7],16,-155497632);
b=md5_hh(b,c,d,a,x[i+10],23,-1094730640);
a=md5_hh(a,b,c,d,x[i+13],4,681279174);
d=md5_hh(d,a,b,c,x[i+0],11,-358537222);
c=md5_hh(c,d,a,b,x[i+3],16,-722521979);
b=md5_hh(b,c,d,a,x[i+6],23,76029189);
a=md5_hh(a,b,c,d,x[i+9],4,-640364487);
d=md5_hh(d,a,b,c,x[i+12],11,-421815835);
c=md5_hh(c,d,a,b,x[i+15],16,530742520);
b=md5_hh(b,c,d,a,x[i+2],23,-995338651);
a=md5_ii(a,b,c,d,x[i+0],6,-198630844);
d=md5_ii(d,a,b,c,x[i+7],10,1126891415);
c=md5_ii(c,d,a,b,x[i+14],15,-1416354905);
b=md5_ii(b,c,d,a,x[i+5],21,-57434055);
a=md5_ii(a,b,c,d,x[i+12],6,1700485571);
d=md5_ii(d,a,b,c,x[i+3],10,-1894986606);
c=md5_ii(c,d,a,b,x[i+10],15,-1051523);
b=md5_ii(b,c,d,a,x[i+1],21,-2054922799);
a=md5_ii(a,b,c,d,x[i+8],6,1873313359);
d=md5_ii(d,a,b,c,x[i+15],10,-30611744);
c=md5_ii(c,d,a,b,x[i+6],15,-1560198380);
b=md5_ii(b,c,d,a,x[i+13],21,1309151649);
a=md5_ii(a,b,c,d,x[i+4],6,-145523070);
d=md5_ii(d,a,b,c,x[i+11],10,-1120210379);
c=md5_ii(c,d,a,b,x[i+2],15,718787259);
b=md5_ii(b,c,d,a,x[i+9],21,-343485551);
a=safe_add(a,_11);
b=safe_add(b,_12);
c=safe_add(c,_13);
d=safe_add(d,_14);
}
return Array(a,b,c,d);
}
function md5_cmn(q,a,b,x,s,t){
return safe_add(bit_rol(safe_add(safe_add(a,q),safe_add(x,t)),s),b);
}
function md5_ff(a,b,c,d,x,s,t){
return md5_cmn((b&c)|((~b)&d),a,b,x,s,t);
}
function md5_gg(a,b,c,d,x,s,t){
return md5_cmn((b&d)|(c&(~d)),a,b,x,s,t);
}
function md5_hh(a,b,c,d,x,s,t){
return md5_cmn(b^c^d,a,b,x,s,t);
}
function md5_ii(a,b,c,d,x,s,t){
return md5_cmn(c^(b|(~d)),a,b,x,s,t);
}
function core_hmac_md5(key,_38){
var _39=str2binl(key);
if(_39.length>16){
_39=core_md5(_39,key.length*chrsz);
}
var _3a=Array(16),_3b=Array(16);
for(var i=0;i<16;i++){
_3a[i]=_39[i]^909522486;
_3b[i]=_39[i]^1549556828;
}
var _3d=core_md5(_3a.concat(str2binl(_38)),512+_38.length*chrsz);
return core_md5(_3b.concat(_3d),512+128);
}
function safe_add(x,y){
var lsw=(x&65535)+(y&65535);
var msw=(x>>16)+(y>>16)+(lsw>>16);
return (msw<<16)|(lsw&65535);
}
function bit_rol(num,cnt){
return (num<<cnt)|(num>>>(32-cnt));
}
function str2binl(str){
var bin=Array();
var _46=(1<<chrsz)-1;
for(var i=0;i<str.length*chrsz;i+=chrsz){
bin[i>>5]|=(str.charCodeAt(i/chrsz)&_46)<<(i%32);
}
return bin;
}
function binl2str(bin){
var str="";
var _4a=(1<<chrsz)-1;
for(var i=0;i<bin.length*32;i+=chrsz){
str+=String.fromCharCode((bin[i>>5]>>>(i%32))&_4a);
}
return str;
}
function binl2hex(_4c){
var _4d=hexcase?"0123456789ABCDEF":"0123456789abcdef";
var str="";
for(var i=0;i<_4c.length*4;i++){
str+=_4d.charAt((_4c[i>>2]>>((i%4)*8+4))&15)+_4d.charAt((_4c[i>>2]>>((i%4)*8))&15);
}
return str;
}
function binl2b64(_50){
var tab="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var str="";
for(var i=0;i<_50.length*4;i+=3){
var _54=(((_50[i>>2]>>8*(i%4))&255)<<16)|(((_50[i+1>>2]>>8*((i+1)%4))&255)<<8)|((_50[i+2>>2]>>8*((i+2)%4))&255);
for(var j=0;j<4;j++){
if(i*8+j*6>_50.length*32){
str+=b64pad;
}else{
str+=tab.charAt((_54>>6*(3-j))&63);
}
}
}
return str;
}
function setSearchTypeGSP(type){
$("tempSearchType").value=type;
var _1ba=$("tempkeyword");
var _1bb=$("tempKeywordHolder");
var _1bc=$("tempLocationHolder");
if(_1bb.getAttribute("origWidth")==null||_1bb.getAttribute("origWidth")==""){
_1bb.setAttribute("origWidth",_1bb.offsetWidth);
}
if(_1bc.getAttribute("origWidth")==null||_1bc.getAttribute("origWidth")==""){
_1bc.setAttribute("origWidth",_1bc.offsetWidth);
}
switch(type){
case "question":
_1ba.value="Enter Keywords";
_1ba.setAttribute("default","Enter Keywords");
_1bb.style.width=parseInt(_1bb.getAttribute("origWidth"))+parseInt(_1bc.getAttribute("origWidth"))+"px";
_1bc.style.display="none";
break;
case "blog":
_1ba.value="Enter Keywords";
_1ba.setAttribute("default","Enter Keywords");
_1bb.style.width=parseInt(_1bb.getAttribute("origWidth"))+parseInt(_1bc.getAttribute("origWidth"))+"px";
_1bc.style.display="none";
break;
case "course":
_1ba.value="Enter Institute or Course Name";
_1ba.setAttribute("default","Enter Institute or Course Name");
_1bb.style.width=_1bb.getAttribute("origWidth")+"px";
_1bc.style.display="";
break;
}
return true;
}
function sendMailtoUser1(_1bd){
hideOverlay();
showOverlay(335,400,"Sign In",$("usershortLoginOverlay").innerHTML,false,parseInt(document.body.offsetWidth)/2-167,150);
$("usershortLoginOverlay").innerHTML="";
overlayParent=$("usershortLoginOverlay");
$("genOverlayContents").style.background="#FFF";
$("genOverlayHolderDiv").style.background="#E4F0FF";
$("overlayShadow2").className="";
$("overlayTitle").innerHTML=" Forgot Password";
$("overlayShadow3").className="";
$("overlayContainer4").className="";
$("rememberme_marketing").style.display="none";
var _1be=$("username_marketing").value;
$("password_marketing").style.display="none";
$("pass").style.display="none";
$("forgetPasswdM").style.display="none";
$("sendRequest").innerHTML="<div style=\"margin-left:88px\"><input id=\"forgotPasswordSubmitBtn\" type=\"submit\" onclick ='return sendForgotPasswordMail(\""+_1be+"\",\"_marketing\")' value=\"Submit\" class=\"continueBtn\" style=\"border:0 none\" /><span style=\"margin-left:15px;\" class=\"normaltxt_11p_blk_arial mar_right_20p\"><a href=\"javascript:void(0);\" id = \"forgetPasswdM\"  onClick = \"return oristate1(this.form)\";>Login</a></span></div><div class=\"clear_L\">&nbsp;</div>";
$("HeaderforOverlay").innerHTML="Forgot Password";
$("username_marketing_error").innerHTML="";
return false;
}
function oristate1(){
hideOverlay();
showOverlay(335,400,"Sign In",$("usershortLoginOverlay").innerHTML,false,parseInt(document.body.offsetWidth)/2-167,150);
$("genOverlayTitleCross_hack").style.display="";
$("usershortLoginOverlay").innerHTML="";
overlayParent=$("usershortLoginOverlay");
$("genOverlayContents").style.background="#FFF";
$("genOverlayHolderDiv").style.background="#E4F0FF";
$("overlayShadow1").className="";
$("overlayShadow2").className="";
$("overlayShadow3").className="";
$("overlayContainer4").className="";
$("password_marketing").style.display="block";
$("pass").style.display="block";
$("forgetPasswdM").style.display="";
$("overlayTitle").innerHTML=" Sign In";
$("rememberme_marketing").style.display="";
$("sendRequest").innerHTML="<div class=\"float_L txt_align_r\" style=\"width:70px\">&nbsp;</div><div style=\"margin-left:91px\"><input type=\"submit\" onclick =\"return isBlank(this.form,'_marketing');\" value=\"Login\" class=\"continueBtn\" style=\"border:0  none\" /><span style=\"display:block;line-height:26px\"><a href=\"javascript:void(0);\" id = \"forgetPasswdM\"  onClick = \"return sendMailtoUser1(this.form)\";>Forgot Password</a></span></div><div class=\"clear_L\">";
if(typeof (page_identifier_unified)!="undefined"&&page_identifier_unified=="homepage"){
$("sendRequest").innerHTML=$("sendRequest").innerHTML+"<span  style=\"display:block; line-height: 26px;margin-left:91px\"><a onclick=\"hideLoginOverlay();callUnifiedOverlay('/user/UnifiedRegistration/loadFormUsingAjax/2',600,350,'homepage');\" href=\"javascript:void(0);\" >New User Register Free</a></span>";
}else{
if(typeof (page_identifier_unified)!="undefined"&&page_identifier_unified=="article"){
arr_unified[0]="2";
arr_unified[1]=$("article_category_id_unified").value;
$("sendRequest").innerHTML=$("sendRequest").innerHTML+"<span  style=\"display:block; line-height: 26px;margin-left:91px\"><a onclick=\"hideLoginOverlay(); callUnifiedOverlay(ShikshaUnifiedRegistarion.url_unified,600,100,'article');\" href=\"javascript:void(0);\" >New User Register Free</a></span>";
}
}
$("username_marketing_error").parentNode.style.display="none";
$("username_marketing_error").innerHTML="";
$("password_marketing_error").innerHTML="";
$("username_marketing").focus();
return false;
}
function showMessagesInline1(_1bf,_1c0){
document.getElementById(_1bf).style.display="";
document.getElementById(_1bf).innerHTML=_1c0;
}
function senduserResponse(){
if(getCookie("userresponse")!=""){
var _1c1=getCookie("userresponse").split("|");
var key=_1c1[0];
var _1c3=_1c1[1];
var ans="";
if(_1c3=="unsubscribe"){
ans=confirm("You would not be allowed to login to shiksha.com once you have unsubscribed.Are you sure you want to unsubscribe from shiksha.com ?");
}
if(ans==true||_1c3=="verify"){
sendResponse(key,_1c3);
}else{
window.setTimeout(function(){
window.location=urlforveri;
},1000);
}
deleteCookie("userresponse");
}
}
function sendResponse(key,flag){
var _1c7=getXMLHTTPObject();
_1c7.onreadystatechange=function(){
if(_1c7.readyState==4){
if(_1c7.responseText!=""){
var msg="";
var _1c9=_1c7.responseText;
var _1ca=_1c9.split("|");
if(_1ca[0]=="deleted"||_1ca[1]=="invalid"){
if(_1ca[0]=="deleted"){
msg="Sorry ! You are no longer a valid shiksha.com user. ";
}
if(_1ca[1]=="invalid"){
msg="Sorry ! The url is not valid. Please click on the link sent in the mailer to update your status ";
}
if(_1ca[0]=="different"||_1ca[0]=="deleted"){
if(getCookie("user")!=""){
deleteCookie("user");
}
}
}else{
if(flag=="verify"){
if(_1ca[1]=="already"){
msg="You have already verified this email address.Kindly add info@shiksha.com to your email account address book so that you never miss on any communication from shiksha.com.";
}else{
msg="Thank you. Your e-mail address is successfully verified with us.Kindly add info@shiksha.com to your email account address book so that you never miss on any communication from shiksha.com.";
}
if(getCookie("user")!=""&&_1ca[0]=="same"){
var _1cb=getCookie("user").split("|");
var _1cc=_1cb[0]+"|"+_1cb[1]+"|verified";
setCookie("user",_1cc);
}
}else{
if(_1ca[1]=="already"){
msg="You have already unsubscribed for this email address.";
}else{
msg="You have successfully unsubscribed from shiksha.com.You would not be allowed to login to shiksha.com.";
}
}
if(getCookie("user")!=""&&(_1ca[0]=="different"||flag=="unsubscribe")){
deleteCookie("user");
}
}
showMessagesInline1("logindiv",msg);
document.getElementById("loginCommunication").style.display="";
window.setTimeout(function(){
window.location=urlforveri;
},1000);
}
}
};
var url="/user/Userregistration/senduserResponse/"+key+"/"+flag;
_1c7.open("POST",url,true);
_1c7.setRequestHeader("Content-length",0);
_1c7.setRequestHeader("Connection","close");
_1c7.send(null);
}
function deleteCookie(name){
var path="/";
var _1d0="";
if(getCookie(name)){
document.cookie=name+"="+((path)?";path="+path:"")+((_1d0)?";domain="+_1d0:"")+";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}
}
var arrayHelpText=eval("eval("+"{\"askanswer\":{\"keywordInput\":\"Enter Keywords\",\"keyword\":\"E.g. Which institute is the best for MBA, IILM, MTECH or MCA etc. \",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"},\"importantdates\":{\"keywordInput\":\"Enter Keywords\",\"keyword\":\"Eg. MBA Tour, CAT admission etc.\",\"locationInput\":\"Enter Location\",\"location\":\"Eg. Australia, Karnataka or Delhi\"},\"entireshiksha\":{\"keywordInput\":\"Enter Keyword\",\"keyword\":\"E.g. MBA, Engineering, XLRI, BBA etc.\",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"},\"0\":{\"keywordInput\":\"Enter Keyword\",\"keyword\":\"E.g. MBA, Engineering, XLRI, BBA etc.\",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"},\"all\":{\"keywordInput\":\"Enter Keyword\",\"keyword\":\"E.g. MBA, Engineering, XLRI, BBA etc.\",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"},\"courses\":{\"keywordInput\":\"Enter Course Name\",\"keyword\":\"E.g. MBA, BTECH, Software Engineering, Animation etc.\",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"},\"institutescourses\":{\"keywordInput\":\"Enter Institute or Course Name\",\"keyword\":\"E.g. MBA,MCA,BBA,Animation,IIM,IIPM etc.\",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"},\"institutes\":{\"keywordInput\":\"Enter Institute Name\",\"keyword\":\"E.g. IIM, Amity, MAAC, JNU etc.\",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"},\"articles\":{\"keywordInput\":\"Enter Keywords\",\"keyword\":\"E.g. MBA , Study Abroad, IILM, MCA etc.\",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"},\"scholarships\":{\"keywordInput\":\"Enter Keywords\",\"keyword\":\"E.g. MBA , Study Abroad, IILM, MBA or MCA etc.\",\"locationInput\":\"Enter Location\",\"location\":\"E.g. Delhi, Pune, Canada etc.\"}}"+")");
function getNumValFromPx(_1d1){
return Number(_1d1.substring(0,(_1d1.length-2)));
}
function slideFormDown(_1d2,_1d3,_1d4,_1d5){
var _1d6=$(_1d5);
if(_1d6.style.display=="block"){
return;
}
var _1d7=_1d2.style.height;
_1d7=getNumValFromPx(_1d7);
var _1d8=0;
_1d3=(_1d3>0)?_1d3:getNumValFromPx(_1d2.style.height);
var _1d9=((_1d3-_1d7)/10);
var _1da=(_1d4/10);
var _1db=0;
$(_1d2.id+"_counter").innerHTML="0";
_1d6.style.display="block";
_1d6.style.height=_1d8+"px";
var _1dc=setInterval(function(){
_1d7+=_1d9;
_1d8+=_1da;
_1d2.style.height=_1d7+"px";
_1d6.style.height=_1d8+"px";
_1db++;
if(_1db>=10){
clearInterval(_1dc);
_1d6.style.height=null;
_1d6.style.overflow="";
}
},(500/10));
clearMessages(_1d2.form,true);
_1d2.style.color="#000";
return;
}
function slideFormUp(_1dd,_1de,_1df){
var _1e0=$(_1df);
if(_1e0.style.display=="none"){
return;
}
var _1e1=_1dd.style.height;
_1e1=getNumValFromPx(_1e1);
_1de=(_1de>0)?_1de:getNumValFromPx(_1dd.style.height);
var _1e2=_1e0.offsetHeight;
var _1e3=((_1e1-_1de)/10);
var _1e4=(_1e2/10);
var _1e5=0;
_1e0.style.display="block";
_1e0.style.overflow="hidden";
var _1e6=setInterval(function(){
_1e1=_1e1-_1e3;
_1e2=_1e2-_1e4;
_1dd.style.height=_1e1+"px";
_1e0.style.height=_1e2+"px";
_1e5++;
if(_1e5>=10){
_1e0.style.display="none";
clearInterval(_1e6);
}
},(500/10));
_1dd.style.color="#a8a7ac";
return;
}
function orangeButtonDisableEnableWithEffect(_1e7,_1e8){
if(_1e8==true){
$(_1e7).setAttribute("disabled",true);
$(_1e7).style.color="#ccc";
}else{
$(_1e7).removeAttribute("disabled");
$(_1e7).style.color="#fff";
}
}
function updatePageCount(_1e9){
window.location=_1e9.value;
}
function hideOverlayAnA(_1ea){
_1ea=(typeof (_1ea)!="undefined")?_1ea:true;
if(typeof isUserLoggedIn!="undefined"&&!isUserLoggedIn&&getCookie("user")!=""&&(anotheraction==0)&&(_1ea)){
window.location.reload();
}else{
dissolveOverlayHackForIE();
$("genOverlayAnA").style.display="none";
if(($("genOverlayContentsAnA").innerHTML!="")&&(overlayParentAnA)){
if(typeof (overlayContent)!="undefined"){
overlayParentAnA.innerHTML=overlayContent;
}else{
overlayParentAnA.innerHTML=$("genOverlayContentsAnA").innerHTML;
}
}
$("genOverlayContentsAnA").innerHTML="";
setNoScroll();
}
}
var overlayParentAnA;
function showOverlayAnA(_1eb,_1ec,_1ed,_1ee,_1ef,left,top){
if(trim(_1ee)==""){
return false;
}
var body=document.getElementsByTagName("body")[0];
$("overlayTitleAnA").innerHTML=_1ed;
if(trim(_1ed)==""){
$("overlayTitleAnA").parentNode.style.display="none";
}else{
$("overlayTitleAnA").parentNode.style.display="";
}
$("genOverlayAnA").style.width=_1eb+"px";
$("genOverlayAnA").style.height=_1ec+"px";
$("genOverlayContentsAnA").innerHTML=_1ee;
var divY=parseInt(screen.height)/2;
var divX;
if(typeof left!="undefined"){
divX=left;
}else{
divX=(parseInt(body.offsetWidth)/2)-(_1eb/2);
}
if(typeof top!="undefined"){
divY=top;
}else{
divY=parseInt(divY-parseInt(_1ec/2))-70;
}
h=document.body.scrollTop;
var h1=document.documentElement.scrollTop;
h=h1>h?h1:h;
divY=divY+h;
if($("genOverlayAnA").scrollHeight<body.offsetHeight){
$("genOverlayAnA").style.left=divX+"px";
$("genOverlayAnA").style.top=divY+"px";
}else{
$("genOverlayAnA").style.left=divX+"px";
$("genOverlayAnA").style.top="100px";
window.scrollTo(divX,"100");
}
overlayHackLayerForIE("genOverlayAnA",body);
$("genOverlayAnA").style.display="inline";
}
function showSalientFeatureOverlay(){
showOverlay(650,500,"Add/Modify Salient Features",$("salientFeatureOverlay").innerHTML);
preserveElementsSelection();
}
function showInstituteTypeSelectionOverlay(){
showOverlay(400,300,"Type of Institute",$("instituteSelectionForm").innerHTML);
}
function showCourseOrderOverlay(_1f6){
var url=SITE_URL+"enterprise/ShowForms/getCourseOrdersForInstitute/"+_1f6;
new Ajax.Request(url,{method:"post",onSuccess:function(_1f8){
var _1f9=_1f8.responseText;
$("courseOrderSelect").innerHTML=_1f9;
showOverlay(400,300,"Please select the order of your courses",$("courseOrderForm").innerHTML);
}});
}
function in_array(_1fa,_1fb){
for(var i=0;i<_1fb.length;i++){
if(_1fb[i]==_1fa){
return true;
}
}
return false;
}
function saveCourseOrder(){
var _1fd=document.getElementById("overlay_institute_id").value;
var _1fe=document.getElementsByName("course_ids[]");
var _1ff=document.getElementsByName("course_order[]");
var _200=new Array();
for(var i=0;i<_1ff.length/2;i++){
if(!in_array(_1ff[i].value,_200)){
_200.push(_1ff[i].value);
}else{
alert("Enter unique course order");
return false;
}
}
var _202=new Array();
for(var i=0;i<_1fe.length/2;i++){
_202.push(_1fe[i].value);
}
var url=SITE_URL+"enterprise/ShowForms/saveCourseOrdersForInstitute/"+_1fd;
var data="courseIds="+_202.join()+"&courseOrders="+_200.join();
new Ajax.Request(url,{method:"post",parameters:(data),onSuccess:function(_205){
hideLoginOverlay();
}});
}
function showOverlayForLDBRegistration(){
if(checkForUnifiedObjectAndMethod()){
register_free_button_identifier_for_tracking="registerfreebutton";
callUnifiedOverlay("/user/UnifiedRegistration/loadFormUsingAjax/2",600,350,"homepage","homepageregisterbutton");
}
return false;
}
function facebookUserDetails(_206,_207,_208,_209,_20a,_20b){
var _20c="https://graph.facebook.com/me/picture?type=small&access_token="+_20a;
var _20d="https://graph.facebook.com/me/friends?access_token="+_20a;
setFBCookie(_20b,_206,_207,_208,_209,_20c,_20d,_20a);
}
function setFBCookie(_20e,_20f,_210,_211,_212,_213,_214,_215){
setCookie("FBCookieCheck","1",15*FB_USER_INFO_COOKIE,"seconds");
setCookie("FBEmailCookieCheck",_20f,FB_USER_INFO_COOKIE,"seconds");
setCookie("FBDisplayNameCookieCheck",_211,FB_USER_INFO_COOKIE,"seconds");
setCookie("FBLastNameCookieCheck",_212,FB_USER_INFO_COOKIE,"seconds");
setCookie("FBFirstNameCookieCheck",_210,FB_USER_INFO_COOKIE,"seconds");
setCookie("FBPhotoCookieCheck",_213,FB_USER_INFO_COOKIE,"seconds");
setCookie("FBFriendsCookieCheck",_214,FB_USER_INFO_COOKIE,"seconds");
setCookie("FBAccessToken",hex_md5(_215),FB_USER_INFO_COOKIE,"seconds");
if(_20e=="request-E-BrochureDirect"){
window.location.reload();
}
if(_20e=="followInstituteDirect"){
setFbAttributeValues(_20e,_20f,_210,_211,_212,_213,_214);
}
}
function deleteFBCookie(){
var _216=((new Date()).getTime())/1000;
setCookie("FBCookieCheck","2",_216+86400,"seconds");
setCookie("FBEmailCookieCheck","",_216-3600,"seconds");
setCookie("FBDisplayNameCookieCheck","",_216-3600,"seconds");
setCookie("FBLastNameCookieCheck","",_216-3600,"seconds");
setCookie("FBFirstNameCookieCheck","",_216-3600,"seconds");
setCookie("FBPhotoCookieCheck","",_216-3600,"seconds");
setCookie("FBFriendsCookieCheck","",_216-3600,"seconds");
setCookie("FBAccessToken","",_216-3600,"seconds");
saveFBAccessTokenFlag=1;
url="/facebook/FacebookF/deleteFBCookie";
data="current_time="+_216;
new Ajax.Request(url,{method:"post",parameters:(data)});
}
function checkLdbUser(){
var _217="";
var _218=new sack();
_218.requestFile="/user/UnifiedRegistration/isLDBUser";
_218.method="POST";
_218.setVar("","");
_218.onError=function(){
};
_218.onLoading=function(){
};
_218.onCompletion=function(){
unified_registration_is_ldb_user=eval("eval("+_218.response+")").UserId;
unified_registration_ldb_user_pref_id=eval("eval("+_218.response+")").PrefId;
try{
if($("subm")&&(unified_registration_is_ldb_user=="true")){
$("subm").disabled=true;
}
if($("submAbroad")&&(unified_registration_is_ldb_user=="true")){
$("submAbroad").disabled=true;
}
}
catch(e){
}
};
_218.runAJAX();
}
function executeGoogleTrackingCode(){
var ifm=document.createElement("iframe");
ifm.setAttribute("src","/public/conversion/conversionRequestEbrochure.html");
ifm.setAttribute("height",0);
ifm.setAttribute("width",0);
ifm.setAttribute("border",0);
document.body.appendChild(ifm);
}
function htmlspecialchars(str){
return str.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/'/g,"&#039;").replace(/"/g,"&quot;");
}

