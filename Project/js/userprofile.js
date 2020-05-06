function uploadAPhoto()
{
    var x=document.getElementById("spanProfilePhotoInput");
    if(x.style.display == "none")
    {
        x.style.display="inline";
        document.getElementById("uploadBtn").style.display="block";
    }
    else if(x.style.display == "inline")
    {
        x.style.display="none";
        document.getElementById("errorProfilePhoto").innerHTML="";
        document.getElementById("uploadBtn").style.display="none";
    }
}

function checkPhotoSize()
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
