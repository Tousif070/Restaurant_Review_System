function loadNewsfeed(id)
{
    var ajax=new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            document.getElementById("newsfeed").innerHTML=ajax.responseText;
        }
    };
    ajax.open("GET", "control_logic/loadnewsfeed.php?id=" + id, true);
    ajax.send();
}
