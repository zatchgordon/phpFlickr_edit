<!DOCTYPE html>
    <head>
    <style type="text/css">
    body{
    	background: url(img/background.png);
    	margin-left:auto;
    	margin-right:auto;
    	width:75%;
    	
    }
   
        #albums{
            float:left;
            clear:both;
           font-variant: small-caps;
            margin-bottom:40px;
        }
        li{
        	list-style-type:none;
            display:inline-block;
            margin-right:40px;
            font-size:1.3em;
            color:#ddd;
            font-family:"Helvitca";
            
        }
        li:hover{
        	cursor: pointer;
        	font-weight:bold;
        	text-decoration:underline;
        }
        #input{
        	clear:both;
        }
        #photos{
            float:left;
            clear:both;
            
        }
        .bwWrapper:hover {
            -webkit-filter: grayscale(0%);
            -webkit-clip-path: polygon(0 0, 0% 100%, 100% 100%,100% 0%); 
            -webkit-transition: .5s ease-in-out;
            -moz-filter: grayscale(0%);
            -moz-transition: .5s ease-in-out;
            -o-filter: grayscale(0%);
            -o-transition: .5s ease-in-out;
        }

        .bwWrapper {
            width:23%;
            -webkit-filter: grayscale(100%);
            -webkit-transition: .5s ease-in-out;
            -moz-filter: grayscale(100%);
            -moz-transition: .5s ease-in-out;
            -o-filter: grayscale(100%);
            -o-transition: .5s ease-in-out;
            -webkit-clip-path: polygon(50% 0, 90% 50%, 50% 100%,10% 50%);
            -o-clip-path: polygon(50% 0, 100% 50%, 50% 100%, 0 50%);
            -moz-clip-path: polygon(50% 0, 100% 50%, 50% 100%, 0 50%);
            -ms-clip-path: polygon(50% 0, 100% 50%, 50% 100%, 0 50%);
            clip-path: polygon(50% 0, 100% 50%, 50% 100%, 0 50%);
            position:relative;
            

        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="lib/jquery.mousewheel-3.0.6.pack.js"></script>

    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="source/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.5" media="screen" />

    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
    <script type="text/javascript" src="source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <script type="text/javascript" src="source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>


        <script type="text/javascript">


            function getInfo(title, list, user)
            {
                console.log("getAlbums loop");
                return $.ajax({
                    url: "photosetid.php",
                    type: "POST",
                    dataType : "json",
                    data : {
                        title: title,
                        list: list,
                        user: user
                    }

                }).promise();
            }

            function showPhotos(prom, css){
            	$(css).html("<h1>Waiting.....</h1>");
                prom.done(function(data){
                    console.log(data);
                    $(css).stop().fadeTo(0,0);
                    $(css).html("");
                    var photos= "";
                   // $(css).append("<h3>"+data[0]+"</h3" + ">");
                    for(var ct=0; ct < data[0]['photoset']['photo'].length; ct++) {

                        photos += "<img src='https://farm" + data[0]['photoset']['photo'][ct].farm + ".staticflickr.com/" + data[0]['photoset']['photo'][ct].server + "/" + data[0]['photoset']['photo'][ct].id + "_" + data[0]['photoset']['photo'][ct].secret + ".jpg' class='bwWrapper'>";
                        

                    }
                    $(css).append(photos);
                    $('img').load(function(){
                    	$('img').animate({
                        
                        }, 0);
					$(css).stop().fadeTo(2000,1);
					});

                 /* fancybox stuff  \

                 $('.bwWrapper').fancybox({
                        prevEffect : 'none',
                        nextEffect : 'none',

                        closeBtn  : false,
                        arrows    : false,
                        nextClick : true,

                        helpers : {
                            thumbs : {
                                width  : 50,
                                height : 50,


                }
                        }
                    });
                    */







                });
                prom.fail(function(data){
                    console.log("promise failed");
                    console.log(data);
                });


            };

            function showAlbums(prom, css){
					$(css).html("<h1>Waiting.....</h1>");
					$('#photos').html("");
                prom.done(function(data){
                    $(css).html(""); 
                    console.log(data);
					if((data[0]!=false && data[0]['photoset'].length>0)){
                    for(var ct=0; ct < data[0]['photoset'].length; ct++) {

                        var photos = "<li data-id='"+ data[0]['photoset'][ct]['id'] +"'> "+data[0]['photoset'][ct]['title']['_content'] +" </li>";
                        $(css).append(photos);

                    }

					}else{
						$(css).html("<h1>no username or albums were found</h1>");
					}

                });
                prom.fail(function(data){
                    console.log("promise failed");
                    $(css).html("<h1>no username found</h1>");
                    $('#albums').html(data["responseText"]);
                });
				
		
				
            }




            $(document).ready(function()
            {
            	
            	
            	
            	
                //var albums= getInfo("real_album", false, "");
                //console.log(albums);
                //display(albums, "#albums");
				 $("#user").keypress(function(e) {
                if (e.keyCode == 13) {
                    var total= getInfo("nothing", "true", $('#user').val());
                    showAlbums(total, '#albums');
                }
            });
                $('#enter').click(function(){
                    var total= getInfo("nothing", "true", $('#user').val());
                    showAlbums(total, '#albums');
                });

                $('#photos').on({
                    mouseenter: function() {
                    	window.normal = $( this ).css('margin');
						console.log(normal);
                        $(this).stop().animate({
                           'margin': '-20px 0px 20px 0px'
                        }, 200);
                    },
                    mouseleave: function() {
                        $(this).stop().animate({
                            margin: '0px 0px 0px 0px'
                        }, 200);
                    }
                }, 'img');
			
                $('#albums').on('click', 'li', function() {
                		$('li').css('text-decoration','none');
                		$(this).css('text-decoration','underline');
                		$('li').css('color','#ddd');
                		$(this).css('color','#999');
                		
                		
                        var albums= getInfo($(this).attr('data-id'), false, "");
                        showPhotos(albums, "#photos");
                    })
            });


        </script>
    </head>

    <body>
        <div id="input">
        	<input type="text" id="user" placeholder="Flickr Username" /><button id="enter">Enter</button>
        </div>
        <div>
        	<ul id="albums">
        	</ul>
        </div>
        <div id="photos">

        </div>
    </body>
</html>

