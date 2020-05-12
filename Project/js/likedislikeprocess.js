function likeDislikeProcess(value, id)
{
    console.log(value + " and " + id);
    var ajax=new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            document.getElementById(id).innerHTML=ajax.responseText;
        }
    };
    ajax.open("GET", "control_logic/likedislikeprocess.php?value=" + value + "&id=" + id, true);
    ajax.send();
}
