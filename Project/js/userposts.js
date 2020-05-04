function uploadAPhoto()
{
    var x=document.getElementById("spanPhotoInput");
    if(x.style.display == "none")
    {
        x.style.display="inline";
    }
    else if(x.style.display == "inline")
    {
        x.style.display="none";
    }
}

function mentionARestaurant()
{
    var x=document.getElementById("spanRestaurantInput");
    if(x.style.display == "none")
    {
        x.style.display="inline";
    }
    else if(x.style.display == "inline")
    {
        x.style.display="none";
        document.getElementById("searchResults").innerHTML="";
        document.getElementById("restaurantInput").value="";
        document.getElementById("searchedRestaurantID").value="";
    }
}

function searchRestaurant()
{
    var text=document.getElementById("restaurantInput").value;
    if(text == "")
    {
        document.getElementById("searchResults").innerHTML="";
        document.getElementById("searchedRestaurantID").value="";
        return;
    }
    var ajax=new XMLHttpRequest();
    ajax.onreadystatechange=function(){
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            document.getElementById("searchResults").innerHTML=ajax.responseText;
        }
    };
    ajax.open("GET", "control_logic/userpostsrestaurantsearch.php?text=" + text, true);
    ajax.send();
}

function selectRestaurant(text, id)
{
    document.getElementById("restaurantInput").value=text;
    document.getElementById("searchResults").innerHTML="";
    document.getElementById("searchedRestaurantID").value=id;
}

function checkPostText()
{
    var text=document.getElementById("postText").value;
    if(text == "")
    {
        document.getElementById("emptyPostText").innerHTML="Text Area Is Empty !";
        document.getElementById("emptyPostText").style.paddingBottom="10px";
        return false;
    }
    else
    {
        document.getElementById("emptyPostText").innerHTML="";
        document.getElementById("emptyPostText").style.paddingBottom="0px";
        return true;
    }
}

function checkPhotoSize()
{
    var x=document.getElementById("photoInput");
    if(x.files[0] == null)
    {
        return true; // IN THIS CASE, THE USER DID NOT SELECT ANY PHOTO FOR UPLOADING THE POST
    }
    if(x.files[0].size > 1000000)
    {
        document.getElementById("errorPhoto").innerHTML="Photo Size Should Be Less Than 1 MB !";
        return false;
    }
    else
    {
        document.getElementById("errorPhoto").innerHTML="";
        return true;
    }
}
