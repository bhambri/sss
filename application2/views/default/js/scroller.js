/***********************************************************************
 * Fortune Realty          
 * Version 1.0                      
 * Copyright (C) 2007                            
 * WWW: http://www.segnant.com
 * Author Abhay Garg
 * Creation Date 11/12/2007 5:33:53 PM
 ************************************************************************/
if (document.images)
{
	img1 = new Image(100,10);
	img1.src = "images/btn_show_shortcuts.png";
	img2 = new Image(100,10);
	img2.src = "images/btn_hide_shortcuts.png";
}
	x=48;
	y=96;
	var tempX;
	var globalX;
	var fullyOpened;
	function scrollDown() 
	{ 
		
		if (x <= 96)
		{
			//document.all("Layer1").moveTo(x,y)
			try
			{			
				document.all("Layer1").style.top = x + 'px';
			}
			catch (ex)
			{
				tempX = x + 'px';
				document.getElementById("Layer1").style.top = tempX;
			}
			if (x > 94)
				 {
					try
					{	
						document.all("Layer1").stop;
						document.all("Layer1").style.top = '96px';
					}
					catch (ex)
					{
						tempX = 96 + 'px';
						document.getElementById("Layer1").stop;
						document.getElementById("Layer1").style.top = tempX;
					}
					fullyOpened = true;
				}
			else
				 {
					x=x+1.7;
					setTimeout("scrollDown()",2);
				}
			globalX	= x;
			//fullyOpened = true;
		}	
	}
	function scrollUp()
	{ 
		
		if (globalX >= 48)
		{
			//document.all("Layer1").moveTo(x,y)
			try
			{
				document.all("Layer1").style.top = globalX + 'px';
			}
			catch (ex)
			{
				tempX = globalX + 'px';
				document.getElementById("Layer1").style.top = tempX;
			}
			if (globalX < 50)
				 {
					try
					{
						document.all("Layer1").stop;
						document.all("Layer1").style.top = '48px';
					}
					catch (ex)
					{
						tempX = 48 + 'px';
						document.getElementById("Layer1").stop;
						document.getElementById("Layer1").style.top = tempX;
					}
					fullOpened = false;
				}
			else
				 {
					globalX=globalX-2;
					setTimeout("scrollUp()",2);
				}
				x = globalX;
		}
	}
