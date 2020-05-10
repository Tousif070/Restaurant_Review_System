function uploadProfilePhoto()
{
    var x=document.getElementById("spanProfilePhotoInput");
    if(x.style.display == "none")
    {
        x.style.display="inline";
        document.getElementById("uploadBtn1").style.display="block";
    }
    else if(x.style.display == "inline")
    {
        x.style.display="none";
        document.getElementById("errorProfilePhoto").innerHTML="";
        document.getElementById("uploadBtn1").style.display="none";
    }
}

function checkProfilePhotoSize()
{
    var x=document.getElementById("profilePhotoInput");
    if(x.files[0] == null)
    {
        document.getElementById("errorProfilePhoto").innerHTML="No Photo Was Selected !";
        return false; // IN THIS CASE, THE USER DID NOT SELECT ANY PHOTO
    }
    if(x.files[0].size > 1000000)
    {
        document.getElementById("errorProfilePhoto").innerHTML="Photo Size Should Be Less Than 1 MB !";
        return false;
    }
    else
    {
        document.getElementById("errorProfilePhoto").innerHTML="";
        return true;
    }
}

function uploadMenuPhoto()
{
    var x=document.getElementById("spanMenuPhotoInput");
    if(x.style.display == "none")
    {
        x.style.display="inline";
        document.getElementById("uploadBtn2").style.display="block";
    }
    else if(x.style.display == "inline")
    {
        x.style.display="none";
        document.getElementById("errorMenuPhoto").innerHTML="";
        document.getElementById("uploadBtn2").style.display="none";
    }
}

function checkMenuPhotoSize()
{
    var x=document.getElementById("menuPhotoInput");
    if(x.files[0] == null)
    {
        document.getElementById("errorMenuPhoto").innerHTML="No Photo Was Selected !";
        return false; // IN THIS CASE, THE USER DID NOT SELECT ANY PHOTO
    }
    if(x.files[0].size > 1000000)
    {
        document.getElementById("errorMenuPhoto").innerHTML="Photo Size Should Be Less Than 1 MB !";
        return false;
    }
    else
    {
        document.getElementById("errorMenuPhoto").innerHTML="";
        return true;
    }
}

function enableEdit()
{
    document.getElementById("aboutRestaurant").disabled=false;
}

function editAboutRestaurant()
{
    var text=document.getElementById("aboutRestaurant").value;
    if(text == "")
    {
        document.getElementById("errorAbout").innerHTML="Your About Section Can Not Be Empty !";
        document.getElementById("errorAbout").style.color="#D1151F";
    }
    else
    {
        var ajax=new XMLHttpRequest();
        ajax.onreadystatechange=function(){
            if(ajax.readyState == 4 && ajax.status == 200)
            {
                document.getElementById("errorAbout").innerHTML=ajax.responseText;
                document.getElementById("errorAbout").style.color="#009F25";
                document.getElementById("aboutRestaurant").disabled=true;
            }
        };
        ajax.open("GET", "control_logic/profileedits.php?value=about&text=" + text, true);
        ajax.send();
    }
}
