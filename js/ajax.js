var xmlHttp;
var serverUrl = "http://localhost/data/c3docs/";
function getXMLHttp() {
	var xmlHttp1;
	try {  // Firefox, Opera 8.0+, Safari
		xmlHttp1=new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer
		try {
			xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				alert("Your browser does not support AJAX!");
				return null;
			}
		}
	}
	return xmlHttp1;
}


//
function getItems(functionId)
{
	
   xmlHttp = null;
    xmlHttp = getXMLHttp();

    if(xmlHttp == null)
        return;
	

var url = serverUrl+"ajax/getitems.php?fid="+functionId;
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged()
{
 if(xmlHttp.readyState == 4 && xmlHttp.status == 200){

  document.getElementById("itemdiv").innerHTML=xmlHttp.responseText;
  }
}

// for forgot-password
function getForm()
{	
 var uname = document.getElementById('boxLostUsername').checked;
 var pwd = document.getElementById('boxLostPassword').checked;
 
 if((uname == true)&&(pwd == true))
 {
	 var type = "both";
 }
 else if((uname == false)&&(pwd == true))
 {
	 var type = "pwd";
 }
 else if((uname == true)&&(pwd == false))
 {
	 var type = "uname";
 }
 else
 {
   var type = "empty";	 
 }
 //alert(type);
   xmlHttp = null;
    xmlHttp = getXMLHttp();

    if(xmlHttp == null)
        return;
	

var url = serverUrl+"ajax/getform.php?type="+type;
xmlHttp.onreadystatechange=stateChangedf;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedf()
{
 if(xmlHttp.readyState == 4 && xmlHttp.status == 200){

  document.getElementById("ajaxContent").innerHTML=xmlHttp.responseText;
  }
}


