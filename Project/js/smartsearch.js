function search(obj)
{
    var text=obj.value;
    if(text == "")
    {
        document.getElementById("searchResults").innerHTML="";
    }
    else
    {
        var ajax=new XMLHttpRequest();
        ajax.onreadystatechange=function(){
            if(ajax.readyState == 4 && ajax.status == 200)
            {
                document.getElementById("searchResults").innerHTML=ajax.responseText;
            }
        };
        ajax.open("GET", "control_logic/smartsearch.php?text=" + text, true);
        ajax.send();
    }
}
