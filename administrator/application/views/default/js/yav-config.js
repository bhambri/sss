/***********************************************************************
 *	Enhanced By: Vipan Balrai
 *  Original By: YAV
 ***********************************************************************/

var yav_config = {

// CHANGE THESE VARIABLES FOR YOUR OWN SETUP

// if you want yav to highligh fields with errors

inputhighlight : true,

// if you want to use multiple class names

multipleclassname : true,

// classname you want for the error highlighting

inputclasserror : 'inputError',

// classname you want for your fields without highlighting

inputclassnormal : 'inputNormal',

// classname you want for the inner error highlighting

innererror : 'innerError',

// classname you want for the inner help highlighting

innerhelp : 'innerHelp',

// div name where errors (and help) will appear (or where jsVar variable is dinamically defined)

errorsdiv : 'errorsDiv',

// if you want yav to alert you for javascript errors (only for developers)

debugmode : false,

// if you want yav to trim the strings

trimenabled : true,

//jQuery Alert Box Customizations
//Title of the alert dialog box.
jQueryAlertTitle : 'Alert',

//Callback function of the alert dialog box; null if do not want to use callback functionality
jQueryAlertCallback : null,

// vertical offset of the dialog from center screen, in pixels

verticalOffset : -200, 

// horizontal offset of the dialog from center screen, in pixels/

horizontalOffset : 0, 

// re-centers the dialog on window resize

repositionOnResize : true, 

// transparency level of overlay

overlayOpacity : .33,          

// base color of overlay

overlayColor : '#666', 

// make the dialogs draggable (requires UI Draggables plugin)

draggable : true,     

// text for the OK button

okButton : '&nbsp;OK&nbsp;', 

// text for the Cancel button

cancelButton : '&nbsp;Cancel&nbsp;', 

// if specified, this class will be applied to all dialogs

dialogClass : null,                  

// change to set your own decimal separator and your date format

DECIMAL_SEP : '.',
THOUSAND_SEP : ',',
DATE_FORMAT : 'MM-dd-yyyy',

// change to set your own rules based on regular expressions

alphabetic_regex : '^[A-Za-z]*$',
alphanumeric_regex : '^[A-Za-z0-9]*$',
alnumhyphen_regex : '^[A-Za-z0-9_-]*$',
alnumhyphenat_regex : '^[A-Za-z0-9_@-]*$',
alphaspace_regex : '^[A-Za-z0-9_ \\n\\r\\t-]*$',
email_regex : '^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$',
phone_regex : '^[+]?[0-9.,() -]{10,20}$',
colorcode_regex : '^[#]?(([0-9a-fA-F]{3})|([0-9a-fA-F]{6}))$',
doc_regex : '^([^ ]+)\\.(pdf|txt|doc|csv|docx)$', //add remove | separated extensions to allow/disallow
image_regex : '^([^ ]+)\\.(jpg|gif|png)$', //add remove | separated extensions to allow/disallow
media_regex : '^([^ ]+)\\.(mpg|swf|wma|wav)$', //add remove | separated extensions to allow/disallow
url_regex : '^(http[s]?://|ftp://)?(www\\.)?[a-zA-Z0-9-._]+\\.([a-zA-Z]{2,4})$',
username_regex : '^[0-9a-zA-Z_.-]{4}[0-9a-zA-Z_.-]*$',
password_regex : '^.{6}.*$',
date_mmddyyyy : '^([1][0-2]|0?[1-9])[ /.-]([1-2][0-9]|30|31|0?[1-9])[ /.-]([1-9][0-9]{3})$',
date_ddmmyyyy :	'^([1-2][0-9]|30|31|0?[1-9])[ /.-]([1][0-2]|0?[1-9])[ /.-]([1-9][0-9]{3})$',
date_yyyymmdd :	'^([1-9][0-9]{3})[ /.-]([1][0-2]|0?[1-9])[ /.-]([1-2][0-9]|30|31|0?[1-9])$',



// change to set your own rule separator

RULE_SEP : '|',

// change these strings for your own translation (do not change {n} values!)

HEADER_MSG : '',
FOOTER_MSG : '',
DEFAULT_MSG : 'The data is invalid.',
REQUIRED_MSG : 'Enter {1}.',
ALPHABETIC_MSG : '{1} is not valid. Characters allowed: A-Za-z',
ALPHANUMERIC_MSG : '{1} is not valid. Characters allowed: A-Za-z0-9',
ALNUMHYPHEN_MSG : '{1} is not valid. Characters allowed: A-Za-z0-9\-_',
ALNUMHYPHENAT_MSG : '{1} is not valid. Characters allowed: A-Za-z0-9\-_@',
ALPHASPACE_MSG : '{1} is not valid. Characters allowed: A-Za-z0-9\-_space',
MINLENGTH_MSG : '{1} must be at least {2} characters long.',
MAXLENGTH_MSG : '{1} must be no more than {2} characters long.',
NUMRANGE_MSG : '{1} must be a number in {2} range.',
DATE_MSG : '{1} is not a valid date, using the format MM-dd-yyyy.',
NUMERIC_MSG : '{1} must be a number.',
INTEGER_MSG : '{1} must be an integer',
DOUBLE_MSG : '{1} must be a decimal number.',
REGEXP_MSG : '{1} is not valid. Format allowed: {2}.',
EQUAL_MSG : '{1} must be equal to {2}.',
NOTEQUAL_MSG : '{1} must be not equal to {2}.',
DATE_LT_MSG : '{1} must be previous to {2}.',
DATE_LE_MSG : '{1} must be previous or equal to {2}.',
EMAIL_MSG : '{1} must be a valid e-mail.',
EMPTY_MSG : '{1} must be empty.',
PHONE_MSG : '{1} must be a valid phone number. Characters allowed: 0-9-.,+()space.',
COLORCODE_MSG : '{1} must be a valid HEX color code.',
DOC_MSG : '{1} must be a valid document type/extension. White spaces are not allowed in the document name. Documents allowed: doc,txt,csv,pdf,docx.',
IMAGE_MSG : '{1} must be a valid image type/extension. Images allowed: jpg,png,gif.',
MEDIA_MSG : '{1} must be a valid media type/extension. Media types allowed: swf,avi,wma,wmv,flv,mp3,mpg.',
URL_MSG : '{1} must be a valid URL. Valid format: http://www.example.com, ftp://www.example.com',
USERNAME_MSG : '{1} must be a valid username. It must be atleast 4 characters long without symbols.',
PASSWORD_MSG : '{1} must be a valid pasword. It must be atleast 6 characters long.',
DATE_MMDDYYYY_MSG : '{1} must be a valid MM-DD-YYYY format.',
DATE_DDMMYYYY_MSG : '{1} must be a valid DD-MM-YYYY format.',
DATE_YYYYMMDD_MSG : '{1} must be a valid YYYY-MM-DD format.',
}//end