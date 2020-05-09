function followProcess(value, id)
{
    var ajax=new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            document.getElementById("followUnfollow").innerHTML=ajax.responseText;
        }
    };
    ajax.open("GET", "control_logic/followingprocess.php?value=" + value + "&id=" + id, true);
    ajax.send();
}
