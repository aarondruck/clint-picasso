<!DOCTYPE html> 
<html> 
<head> 
	<title>Clint Picasso</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.2.0.min.css" />
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.2.0.min.js"></script>
	<script src="js/sketch.js"></script>
	
	<!-- ADD IN HEADER STUFF FROM CHAT -->
	
	<link rel="stylesheet" href="http://easywebsocket.org/contrib/chat/main.css" />
	<script src="../json2.js"></script>		
	<script src="../easyWebSocket.min.js"></script>
	<script src="../jquery.min.js"></script>
	<script src="../jquery.tmpl.min.js"></script>
	<script src="../jQuery.url.js"></script>
	<script src="../main.js"></script>
	
	<!-- Custom Font -->
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	
	<!-- //// -->
	
	
	<style type="text/css" media="screen">
		
		/*custom CSS to override JQM*/
		body  * {
			font-family: 'Arvo', serif !important;
		    font-weight: normal !important;
		  }
		
		.ui-header {
			background: black !important;
			border:1px solid #000;
		}
		
		#page2, #page4 {
				background: #3f5663 !important;
		}
	
		span.ui-btn-inner {
			display:none;
		}
		a#arrow-right {
			background:url("imgs/icn-right.png") no-repeat !important;
			border:0px solid #fff;
			box-shadow:0px solid #fff;
			-moz-box-shadow: 0 0px 0 rgba(255,255,255,.3) !important;
			-webkit-box-shadow: 0 0px 0 rgba(255,255,255,.3) !important;
			box-shadow: 0 0px 0 rgba(255,255,255,.3) !important;
		}
		
		a#arrow-left {
			background:url("imgs/icn-left.png") no-repeat !important;
			border:0px solid #fff;
			box-shadow:0px solid #fff;
			-moz-box-shadow: 0 0px 0 rgba(255,255,255,.3) !important;
			-webkit-box-shadow: 0 0px 0 rgba(255,255,255,.3) !important;
			box-shadow: 0 0px 0 rgba(255,255,255,.3) !important;
		}
		
		#saveBtn {
			background:url("imgs/btn-save.png") no-repeat !important;
			border:0px solid #000;
			height:48px;
			width:48px;
			box-shadow:none;
		}
		
		#clearBtn {
			background:url("imgs/btn-clear.png") no-repeat !important;
			border:0px solid #000;
			height:48px;
			width:48px;
			box-shadow:none;
		}
		
		/*////*/
		
		#paintBox
		{
		  border:1px solid #ccc;
		  width:100%;
		  height: 280px;
		  background:#fff;
		}
		
		#mycanvas{
			margin-top:-20px;
			border:1px solid #ccc;
		}
		
	</style>
	
	<script type="text/javascript">
	  var canvas = null; //canvas object
	  var context = null; //canvas's context object
	  var clearBtn = null; //clear button object
	  var saveBtn = null; //clear button object

	  /*boolean var to check if the touchstart event
	  is caused and then record the initial co-ordinate*/
	  var buttonDown = false;

	  //onLoad event register
	  window.addEventListener('load', initApp, false);

	  function initApp() {
	    setTimeout(function() { window.scrollTo(0, 1); }, 10); //hide the address bar of the browser.
	    canvas = document.getElementById('paintBox');
	    clearBtn = document.getElementById('clearBtn');
		saveBtn = document.getElementById('saveBtn');

	    setCanvasDmiension();
	    initializeEvents();

	    context = canvas.getContext('2d'); //get the 2D drawing context of the canvas
	}

	function setCanvasDmiension() {
	  //canvas.width = 300; //window.innerWidth;
	  canvas.height = window.innerHeight; //setting the height of the canvas
	}

	function initializeEvents() {
	  canvas.addEventListener('touchstart', startPaint, false);
	  canvas.addEventListener('touchmove', continuePaint, false);
	  canvas.addEventListener('touchend', stopPaint, false);

	  clearBtn.addEventListener('touchend', clearCanvas,false);
	  saveBtn.addEventListener('touchend', save,false);
	}

	function clearCanvas() {
	  context.clearRect(0,0,canvas.width,canvas.height);
	  //alert("Cleared!");
	}

	function startPaint(evt) {
	  if(!buttonDown)
	  {
	    context.beginPath();
	    context.moveTo(evt.touches[0].pageX, evt.touches[0].pageY);
	    buttonDown = true;
	  }
	  evt.preventDefault();
	}

	function continuePaint(evt) {
	  if(buttonDown)
	  {
	    context.lineTo(evt.touches[0].pageX,evt.touches[0].pageY);
	    context.stroke();
	  }
	}

	function stopPaint() {
	  buttonDown = false;
	}
	
	function save()
	{
		alert("Saved!");
	    document.getElementById("canvasimg").style.border="1px solid";
	    var dataURL = canvas.toDataURL();
	    localStorage.setItem('canvasImage', canvas.toDataURL('image/png'));
	    document.getElementById("canvasimg").src = dataURL;
	    document.getElementById("canvasimg").style.display="inline";

	}
	
	
	
	
	</script>
	
</head> 
<body onload="init()"> 
	
	
	
	
	<!-- this just shows the username ID -->
	<div id="container" style="display:none;">
		<div class="header">
			<div class="userContainer">
				<span class="username value">Unknown</span>
			</div>
		</div>
	</div>


	

<!-- Start of INSTRUMENT IDEA -->
<div data-role="page" id="page2">

	<div data-role="header">
		<h1>Draw a picture</h1>
		<a id="arrow-right" href="#page4" data-transition="slide" data-icon="custom"  rel="external" onclick="saveViaAJAX();" class="ui-btn-right" data-iconpos="notext">Next</a>
	</div><!-- /header -->

	<div data-role="content">	
		

	  	<canvas id="paintBox">
	    	Your browser does not support canvas
	  	</canvas>
		
		<center>
			<a href="#" data-role="button" data-inline="true" id="clearBtn"></a>
			<a href="#" data-role="button" data-inline="true" data-theme="b" id="saveBtn" style="display:none"></a>
		</center>


		<script type="text/javascript">
		
		//alert(jQuery("#container .header .username").text());
		
		
		function saveViaAJAX()
		{
				
			var testCanvas = document.getElementById("paintBox");
			var canvasData = testCanvas.toDataURL("image/png");
			var postData = "canvasData="+canvasData;
			var ajax = new XMLHttpRequest();
			
			var PageToSendTo = "testSave.php?";
			var VariablePlaceholder = "variableName=";
			
			//send the USERNAME ID to here... from main.js			
			var MyVariable = jQuery("#container .header .username").text();
			
			//here is the userID, can send to chat.html?
			//send the content in test to the userID and send that to chat.html?
			$("#test").html(MyVariable);
			//alert(MyVariable);
			
			var UrlToSend = PageToSendTo + VariablePlaceholder + MyVariable;
			
			ajax.open("POST",UrlToSend,true);
			ajax.setRequestHeader('Content-Type', 'canvas/upload');

			ajax.onreadystatechange=function()
		  	{
				if (ajax.readyState == 4)
				{
					//alert(ajax.responseText);
					// Write out the filename.
		    		document.getElementById("debugFilenameConsole").innerHTML="Saved as<br><a target='_blank' href='"+ajax.responseText+"'>"+ajax.responseText+"</a><br>Reload this page to generate new image or click the filename to open the image file.";
				}
		  	}

			ajax.send(postData);
			//alert(canvasData);
			
			//UPDATE PROCESSING IMAGE VARIABLE HERE OR FIRE OFF PROCESSING SKETCH SO IT RENDERS
			var pjs = Processing.getInstanceById('mycanvas');
			//alert(canvasData);
			var text = canvasData;
		    pjs.newImage(text);
			///
			
		}

		</script>
		
		<!-- send this userID to chat.html? -->		
		<!-- <div id="test">userID</div> -->
		
		
	</div><!-- /content -->


</div><!-- /page -->

<!-- Start of IFTTT IDEA -->
<div data-role="page" id="page4">

	<div data-role="header">
		<a id="arrow-left" href="#" data-rel="back" data-icon="custom" data-iconpos="notext">Back</a>
		<h1>Fire!</h1>
	</div><!-- /header -->

	<div data-role="content">	
			
			<?php
				$instrumentSound = $_POST["instrumentSound"];
				$filepath = "files/instrument.html";
				$file =fopen($filepath, "w");
				$myHTML = 
					
					"<!DOCTYPE html> 
					<html> 
					<head> 
						<title>My instrument</title> 
						<meta name='viewport' content='width=device-width, initial-scale=1'> 
						<link rel='stylesheet' href='../css/themes/default/jquery.mobile-1.2.0.min.css' />
						<script src='../js/jquery.js'></script>
						<script src='../js/jquery.mobile-1.2.0.min.js'></script>
						<script src='http://code.jquery.com/jquery-latest.js'></script>
						<link rel='apple-touch-icon-precomposed' href='../img/icon-red-57.png'>
						<script>

							
							
						</script>
					</head> 
					<body> 

					<div data-role='page' id='bar'>

						<div data-role='header'>
							<h1>My Instrument</h1>
						</div><!-- /header -->

						<div data-role='content'>	
						      
								<a onclick='this.firstChild.play()'><audio src='../" . $_POST["instrumentSound"] . "'></audio><img src='../images/test.png' style='border:1px solid; width:100%; height:200px;'></a>
						</div><!-- /content -->

						<div data-role='footer'>
							<h4>Page Footer</h4>
						</div><!-- /footer -->

					</div><!-- /page -->

					</body>
					</html>";
				fwrite($file, $myHTML);
				fclose($file);
			?>	
				
				<script type="text/javascript" charset="utf-8">
				    document.getElementById("finalAppName").innerHTML = dataURL;
				</script>
				
				<p>
					
				
				<div id="p1"></div>
				<div id="instrument-button">	
					<!-- <img id="canvasimg" style="display:none;"> -->
				</div>
				
				<canvas id="mycanvas"></canvas>
				
				<script src="http://cloud.github.com/downloads/processing-js/processing-js/processing-1.4.1.min.js"></script>
				
				<script type="application/javascript">
						    
					var jsString = localStorage.getItem('canvasImage');
					// alert(localStorage.getItem('canvasImage'));
					
					//shoots off event from JS
					function fireEvent() {
						ChatAnywhere.prototype.fireThisEvent();						 						
					}
					
					//access within function?
					//chat.sendMessage();
					
					// Sound
					var audioPullBack = document.createElement('audio');
					audioPullBack.setAttribute('src', 'wav/brass.wav');
					
					var audioRelease = document.createElement('audio');
					audioRelease.setAttribute('src', 'wav/fire.mp3');
					
					
				</script>
				
				<script type="text/processing" data-processing-target="mycanvas">
					//initialize variables
					int leftRodTopX = 55;
					int leftRodTopY = 60;
					int rightRodTopX = 235;
					int rightRodTopY = 60;
					int rectLeftX = 150;
					int rectMidX = 145;
					int rectTopY = 500;
					int rectWidth = 10;
					int rectHeight = 100;
					float slingMid = 145;
					float ellipseCenterX = pmouseX;
					float ellipseCenterY = pmouseY;
					float x;
					float y;
					float r;
					float g;
					float b;

					boolean hasBeenReleased = false;
					boolean winner = false;

					PVector press;
					PVector release;

					float gravity = 0;

					PImage b;

					void setup(){
					
						size(290,340);
						background(255);
						smooth();
						fill(50);
																		
						//create initial slingshot
						line(leftRodTopX,leftRodTopY,rightRodTopX,rightRodTopY); //string
						newImage();
						
					}
					
					void newImage(String imageFile) {
						//println("test");
						b = loadImage(imageFile);
					}

					void draw(){
						
						image(b, 100, -20, 100, 139);
						
						if(mousePressed){
								
						  background(255);
						  bezier(900,400,880,375,880,325,912,320);
						  fill(255,0,0);
						  
						  image(b, 100, mouseY-15, 100, 139);
						  noFill();
						  bezier(rightRodTopX,rightRodTopY,145,mouseY,150,mouseY,leftRodTopX,leftRodTopY);
						  fill(0,0,255);
						  noFill();
						  line(rectMidX,rectTopY,rightRodTopX,rightRodTopY);
						  line(rectMidX,rectTopY,leftRodTopX,leftRodTopY);
						  line(145,mouseY,slingMid,leftRodTopY);	
						  
						  				  
						}

						if(mousePressed==false){
						  
						  background(255);
						  noFill();
						  line(rectMidX,rectTopY,rightRodTopX,rightRodTopY);       //right rod
						  line(rectMidX,rectTopY,leftRodTopX,leftRodTopY);         //left rod
						  line(leftRodTopX,leftRodTopY,rightRodTopX,rightRodTopY); //string
						  stroke(0);
						  //img, x, y, w, h
						//initialize
						image(b, 100, -20, 100, 139);
						 }

						 if(hasBeenReleased)
						 {
						   noFill();
						   bezier(900,400,880,375,880,325,912,320);
						   fill(255,0,0);
						   image(b, 100, release.y-240, 100, 139);
						   //ellipse(150, release.y, 40, 40);
						   release.add(press);
						   release.y+=gravity;
						   //gravity+=0.6;
						   //println(release.y); 
						   noFill();
						   bezier(925,400,945,375,945,325,912,320);

						   if(release.y<=0){
						     winner = true;
						   }
						 }

						 if(winner){
						   //alert("test");
						 }
					}

					void mousePressed()
					{
					  // load sound - arrow pull back
					  //audioPullBack.play();
					  press = new PVector(mouseX, mouseY);
					  winner = false;
					}

					void mouseReleased(){
					  float cSquared = sqrt(((mouseY-leftRodTopY)*(mouseY-leftRodTopY))+((slingMid-mouseX)*(slingMid-mouseX)))/5;
					  release = new PVector(mouseX, mouseY);
					  press.sub(release);
					  press.normalize();
					  press.mult(cSquared);
					  hasBeenReleased = true;
					  gravity = 0;
						
					  // FIRE OFF CHAT MESSAG HERE, fire off a Jquery event from main.js					  
					  fireEvent();
					
					  //
					  //LOAD SOUND - arrow released
					  audioRelease.play();
					
					}
					

					
				</script>
				
				<div id="finalSoundpath" style="display:none">image.png</div></p>
				
				<form action="<?php echo $PHP_SELF;?>" method="post" onsubmit="this.formSound.value = document.getElementById('finalSoundpath').innerHTML;" data-ajax="false">
				    <input type="hidden" name="instrumentSound" id="formSound" value="" />
				    <!-- <input type="submit" value="Publish" name="submit" /> -->
				</form>
			
				<!-- SEND A MESSAGE!! -->
				<form id="chat-form" action="#" style="display:none">
					<input class="input" id="chat-input" type="text" />
				</form>	
				
				<div id="rightside">
					<?php
		
							if ($handle = opendir('files/')) {
								//echo "Directory handle: $handle\n";
								
					
							while (false !== ($file = readdir($handle))) {
																
								$pieces = explode(".", $file);
								
									if ($file == '.') {
									    // echo 'true';
									}

									else if ($file == '..') {
									    // echo 'true';
									}

									else if ($file == '.DS_Store') {
									    // echo 'true';
									}

									else if ($file == '.html') {
									    // echo 'true';
									}
									
									else if ($file == 'instrument.html') {
										// echo "<h3>Share the link to your app:</h3>";
										// echo "<a href='files/" . $file . "' target='_blank'>" . $pieces[0] . "</a><br />";
									}
								}
								closedir($handle);
							}
					?> 
				</div>

		
	</div><!-- /content -->


</div><!-- /page -->

</body>
</html>