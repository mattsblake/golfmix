// JavaScript Document
function gCountdownform()
{
	if(document.form1.gCount.value=="")
	{
		alert("Please enter the text.")
		document.form1.gCount.focus();
		return false;
	}
	if(document.form1.gCountmonth.value=="")
	{
		alert("Please select the month.")
		document.form1.gCountmonth.focus();
		return false;
	}
	if(document.form1.gCountdate.value=="")
	{
		alert("Please select the date.")
		document.form1.gCountdate.focus();
		return false;
	}

	if(document.form1.gCountyear.value=="")
	{
		alert("Please select the year.")
		document.form1.gCountyear.focus();
		return false;
	}
	if(document.form1.gCounthour.value=="")
	{
		alert("Please select the hour/time.")
		document.form1.gCounthour.focus();
		return false;
	}
	if(document.form1.gCountzoon.value=="")
	{
		alert("Please select the time zoon AM/PM.")
		document.form1.gCountzoon.focus();
		return false;
	}
	if(document.form1.gCountdisplay.value=="")
	{
		alert("Please select the display status.")
		document.form1.gCountdisplay.focus();
		return false;
	}
}
