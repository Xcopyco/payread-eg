<?php
$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$apikey = $obj['apikey'];
$page="";
$page1 = "<html>
<head>
<script type='text/javascript'>
function check()
{
	    var xhr = new XMLHttpRequest();
	    xhr.open('POST', 'http://payread.ga/', true);		
		var params = {'apikey':document.getElementById('apikey').value};
	    xhr.onreadystatechange = function(){
		 if (xhr.readyState != 4) return;	
	        if (this.readyState == 4) {
	            if (this.status == 200)
				   {
				   var newDoc = document.open('text/html', 'replace');
					newDoc.write(this.responseText);
					newDoc.close();
					}
	        }
	    };
xhr.send(JSON.stringify(params));
}
</script>
</head>
<body>";
$page2 = 
"Please, enter your apikey:
<input id='apikey' placeholder='Enter your apikey here'></input><br/>
<button type='submit' id='checkapi' onclick='check();'>check key</button>
<button id='getapi' onclick='window.open(\"http://signup.xcopy.co\");'>Get Api Key</button>
<br/>
</body>
</html>";
if ((!isset($apikey))||(is_null($apikey)))
{
$page= $page1 . $page2;
}
else
{
$response = file_get_contents("http://app.xcopy.co/o/check?apikey=".$apikey);
if ($response=='1')
{$page = "<html>
<head>
<script type='text/javascript'>
//some default pre init
var XCopy = XCopy || {};
XCopy.q = XCopy.q || [];

//provide xcopy initialization parameters
XCopy.app_key = 'c4eddd4bbdfa858c0c8e16c94f22e7d99018c0e5';
XCopy.url = 'http://app.xcopy.co'; 

//start pushing function calls to queue

//start session on each page view
XCopy.q.push(['begin_session']);

//add any events you want like pageView
XCopy.q.push(['add_event',{
	key:'asyncPageView', 
	'segmentation': {
		'url': window.location.pathname
	}
}]);

//end session on leaving page
window.onunload = function(){
	XCopy.end_session();
};

//load xcopy script asynchronously
(function() {
	var xcp = document.createElement('script'); xcp.type = 'text/javascript'; 
	xcp.async = true;
	//enter url of script here
	xcp.src = 'xcopy.min.js';
	xcp.onload = function(){XCopy.init()};
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(xcp, s);
})();
function clickEvent(ob){
	XCopy.q.push(['add_event',{
		key:'asyncButtonClick', 
		'segmentation': {
			'id': ob.id
		}
	}]);
}
</script>
</head>
<body>
<script type='text/javascript'>
//send event on button click

//window.onload = function(e){ 
//clickEvent(null);   
//}
</script>
<input type='button' id='asyncTestButton' onclick='clickEvent(this)' value='Test Button'>
This is a test page. Press button to start time.
</body>
</html>";
}
else
{
$page = $page1 . "<H2>You have entered a wrong APIKEY</H2>"  . $page2;
}
}
echo $page;

?>