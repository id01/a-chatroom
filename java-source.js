// Configuration
var HYBRID_REFRESH_RATE = 400; // Time between hybrid polls
var LONG_DELAY = 100; // Time between long polls

// Functions
function checktimeout() {
	if (document.cookie.indexOf("PHPSESSID=") < 0) {
		window.location.replace("login.html?note=0");
	}
	else if (document.cookie.indexOf("username=") < 0) {
		logout();
	}
}
function refresh(pollmeth) {
	// First, check timeout
	checktimeout();
	// Short polling
	if ( pollmeth == 0 )
	{
		$("#newnumber").load("data/number.txt");
		var oldd = document.getElementById("number").innerHTML;
		var neww = document.getElementById("newnumber").innerHTML;
		var ress = oldd.localeCompare(neww);
		if (ress != 0)
		{
			frefresh();
		}
	}
	// Hybrid polling
	else if ( pollmeth == 1 )
	{
		$(function() {
			$.ajax({
				url: "longpoll.php",
				timeout: 1000000,
				success: function(response) {
					var myprevnum = document.cookie.substring(document.cookie.indexOf("number")).substring(7, document.cookie.indexOf(';'));
					if (response != myprevnum)
					{
						document.cookie = "number=" + response;
						frefresh();
					}
					// Do some hybrid polling before long polling again
					setTimeout(function() { refresh(2); }, HYBRID_REFRESH_RATE); // Short poll 1
					setTimeout(function() { refresh(2); }, HYBRID_REFRESH_RATE*2); // Short poll 2
					setTimeout(function() { refresh(1); }, HYBRID_REFRESH_RATE*3); // Redo longpoll
				}
			});
		});
	}
	// This is soley to continue hybrid polling
	else if ( pollmeth == 2 )
	{
		$.ajax({
			url: "data/number.txt",
			success: function(response) {
				var ltrimmed = document.cookie.substring(document.cookie.indexOf("number")) + ";";
				var oldd = ltrimmed.substring(7, ltrimmed.indexOf(';'));
				if (oldd != response)
				{
					document.cookie = "number=" + response;
					frefresh();
				}
			}});
	}
	// True long polling
        else if ( pollmeth == 3 )
        {
                $(function() {
                        $.ajax({
                                url: "longpoll.php",
                                timeout: 1000000,
                                success: function(response) {
                                        var myprevnum = document.cookie.substring(document.cookie.indexOf("number")).substring(7, document.cookie.indexOf(';'));
                                        if (response != myprevnum)
                                        {
                                                document.cookie = "number=" + response;
                                                frefresh();
                                        }
                                        setTimeout(function() { refresh(3); }, LONG_DELAY); // Redo longpoll
                                }
                        });
                });
        }

}
function frefresh() {
	$("#messagebox").load("data/messages.txt");
	document.getElementById("number").innerHTML = document.getElementById("newnumber").innerHTML;
	document.getElementById("messagebox").innerHTML += "<br>";
	messagebox.scrollTop = messagebox.scrollHeight;
}
$(function sendmsg(){
	$('#msgsnd').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			type: "post",
			url: "sendmsg.php",
			data: $('form').serialize(),
			success: function () {
				$("#msgsnd")[0].reset();
				document.getElementById("notification").innerHTML = "Message Sent.";
				frefresh();
			}
		});
	});
});
$(function clr()
{
        $('#clearform').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                        type: "post",
                        url: "clearscreen.php",
                        data: $('form').serialize(),
                        success: function () {
                                document.getElementById("notification").innerHTML = "Screen cleared.";
                        }
                });
        });
});
function closeclr()
{
	clearwindow.close();
}
function logout()
{
	window.location.replace("logout.php");
}
