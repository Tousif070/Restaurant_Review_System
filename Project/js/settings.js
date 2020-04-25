function validatePassword()
{
    var validation=true;
    /*var password=document.getElementById("password");
    var repeatPassword=document.getElementById("repeatPassword");
    */
    var password=document.forms["passwordForm"]["password"];
    var repeatPassword=document.forms["passwordForm"]["repeatPassword"];

    if(password.value == "")
    {
        document.getElementById("errorPassword").innerHTML="Please Enter Your New Password !";
        validation=false;
    }
    else if(password.value.length < 8)
    {
        document.getElementById("errorPassword").innerHTML="Password Should Be Minimum Of 8 Characters !";
        validation=false;
    }
    else
    {
        document.getElementById("errorPassword").innerHTML="";
    }

    if(repeatPassword.value == "")
    {
        document.getElementById("errorRepeatPassword").innerHTML="Please Enter Your Password Again !";
        validation=false;
    }
    else if(repeatPassword.value.length < 8)
    {
        document.getElementById("errorRepeatPassword").innerHTML="Password Should Be Minimum Of 8 Characters !";
        validation=false;
    }
    else if(password.value != repeatPassword.value)
    {
        document.getElementById("errorRepeatPassword").innerHTML="Passwords Do Not Match !";
        validation=false;
    }
    else
    {
        document.getElementById("errorRepeatPassword").innerHTML="";
    }

    return validation;
}
