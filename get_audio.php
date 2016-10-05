<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

</head>
<body>

<table align="center" valign="center" border="0">
<tr><td>

<audio id="item_track" class="item_track">
   <source src="ukulele.mp3" type="audio/mpeg" />
   <source src="ukulele.ogg" type="audio/ogg" />
<p>Dieser Browser unterstützt HTML5 audio nicht</p>
</audio>
   <a class="item_track" href="javascript:playpause();">
     <img src="pics/play.png" id="playpausebutton">
   </a>

<script type="text/javascript">
   var audio = document.getElementById('item_track');
   function playpause()
     {
     if (audio.paused)
       { audio.play(); document.getElementById('playpausebutton').src = "pics/stop.png"; }
     else
       { audio.pause();audio.currentTime = 0; document.getElementById('playpausebutton').src = "pics/play.png"; }
     }
</script>


</td></tr></table>

</body>
</html>
