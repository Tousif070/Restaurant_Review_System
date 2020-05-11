function showFilledStars(value)
{
    if(value == 1)
    {
        document.getElementById("star1").src="images/filledstar.png";
    }
    else if(value == 2)
    {
        document.getElementById("star1").src="images/filledstar.png";
        document.getElementById("star2").src="images/filledstar.png";
    }
    else if(value == 3)
    {
        document.getElementById("star1").src="images/filledstar.png";
        document.getElementById("star2").src="images/filledstar.png";
        document.getElementById("star3").src="images/filledstar.png";
    }
    else if(value == 4)
    {
        document.getElementById("star1").src="images/filledstar.png";
        document.getElementById("star2").src="images/filledstar.png";
        document.getElementById("star3").src="images/filledstar.png";
        document.getElementById("star4").src="images/filledstar.png";
    }
    else if(value == 5)
    {
        document.getElementById("star1").src="images/filledstar.png";
        document.getElementById("star2").src="images/filledstar.png";
        document.getElementById("star3").src="images/filledstar.png";
        document.getElementById("star4").src="images/filledstar.png";
        document.getElementById("star5").src="images/filledstar.png";
    }
}

function showHollowStars(value)
{
    if(value == 1)
    {
        document.getElementById("star1").src="images/hollowstar.png";
    }
    else if(value == 2)
    {
        document.getElementById("star1").src="images/hollowstar.png";
        document.getElementById("star2").src="images/hollowstar.png";
    }
    else if(value == 3)
    {
        document.getElementById("star1").src="images/hollowstar.png";
        document.getElementById("star2").src="images/hollowstar.png";
        document.getElementById("star3").src="images/hollowstar.png";
    }
    else if(value == 4)
    {
        document.getElementById("star1").src="images/hollowstar.png";
        document.getElementById("star2").src="images/hollowstar.png";
        document.getElementById("star3").src="images/hollowstar.png";
        document.getElementById("star4").src="images/hollowstar.png";
    }
    else if(value == 5)
    {
        document.getElementById("star1").src="images/hollowstar.png";
        document.getElementById("star2").src="images/hollowstar.png";
        document.getElementById("star3").src="images/hollowstar.png";
        document.getElementById("star4").src="images/hollowstar.png";
        document.getElementById("star5").src="images/hollowstar.png";
    }
}

function ratingProcess(value, id)
{
    var ajax=new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            document.getElementById("rating").innerHTML=ajax.responseText;
        }
    };
    ajax.open("GET", "control_logic/ratingprocess.php?value=" + value + "&id=" + id, true);
    ajax.send();
}
