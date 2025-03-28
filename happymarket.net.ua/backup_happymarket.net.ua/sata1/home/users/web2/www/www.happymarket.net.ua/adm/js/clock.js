function startClock()
{
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
	var month = date.getMonth()+1;
    var amOrPm = (hours > 11) ? "PM" : "AM";

    //hours = (hours > 12) ? hours - 12 : hours;
   // hours = (hours == 0) ? 12 : hours;
    minutes = (minutes <= 9) ? "0" + minutes : minutes;
    seconds = (seconds <= 9) ? "0" + seconds : seconds;
	month = (month <= 9) ? "0" + month : month;
	
    dispTime = date.getDate() + "." + month + "." + date.getFullYear() + " &#160;  " + hours + ":" + minutes + ":" + seconds;

    time.innerHTML = dispTime;

    setTimeout("startClock()", 1000);
}
function category(){};