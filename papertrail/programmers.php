<!DOCTYPE html>
<html>

<style>
    	body{
			font-family: Arial, sans-serif;
            background-image: url(images/ITbg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
		}

		.prog{
			justify-content: center;
			text-align: center;
			font-size: 50px;
			margin-top: 10%;
            margin-bottom: 10px;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
		}

		.pics{
			width: 250px;
			
		}

		.halim{
			display: inline-block;
			margin-left: 20px;
            border: 1px solid white;
		}

		label{
			font-size: 20px;
			margin-top: 20px;
            font-weight: bolder;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
		}

		.col{
			width: 100%
		}

		.btn{
		    background-color: transparent;
		    border: 0;
		}


</style>

<head>
    <title>PTCAO</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/batangas.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<nav class="navbar" style="display: flex; align-items: center; justify-content: space-between; background-color: transparent">
    <div class="navbar-left" style="display: flex; align-items: center;">
        <img src="images/batangas.png" alt="" style="width: 25px; margin-right: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); border-radius: 50%">
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="font-size: 1.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">PTCAO PAPERTRAIL DEVELOPERS</li>
        </ul>
    </div>

        <div class="background-image">

        </div>


    <div class="navbar-right" style="visibility: hidden;">
        <a href="programmers.php"><img src="images/creator.png" style="width: 25px; margin-left: -60px; margin-right: 35px"></a>
        <button id="login-button" class="btn">
        <p style="margin-right: 10px; cursor: pointer"><u>Login</u></p>
            <img src="images/nobg.png" alt="" style="width: 20px;">
        </button>
    </div>
</nav>
    
        <div>
    
            <h1 class="prog">The Programmers</h1>
        </div>
    
        <div class="container" style="padding-left: 405px ">
    
            <div class="halim" style="background-color: #181B25">
            <a href="https://www.facebook.com/shintae081?mibextid=ZbWKwL"><img class="pics" src="images/josh.png" ></a><br>
            <label style="margin-left: 50px">Rehnjosh Mina</label>
            </div>
    
            <div class="halim" style="background-color: #403d41">
            <a href="https://www.facebook.com/profile.php?id=100011115332851&mibextid=ZbWKwL"><img class="pics" src="images/kevs.png"></a><br>
            <label style="margin-left: 60px">Kevin D. Lopez</label>
            </div>
    
            <div class="halim" style="background-color: #2b314f">
            <a href="https://www.facebook.com/rhoniel.matining.3?mibextid=ZbWKwL"><img class="pics" src="images/rhon.jpg" ></a><br>
            <label style="margin-left: 35px">Rhoniel T. Matining</label>
            </div>
    
            <div class="halim" style="background-color: #1F1E1F">
            <a href="https://www.facebook.com/rica.godoy.94?mibextid=ZbWKwL"><img class="pics" src="images/rics.jpg"></a><br>
            <label style="margin-left: 13px">Rica Fiah May G. Godoy</label>
            </div>
    
        </div>

</body>
</html>
