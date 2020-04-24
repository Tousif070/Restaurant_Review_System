function checkUsername()
{
    var text=document.getElementById("username").value;

    if(text == "")
    {
        document.getElementById("errorUsername").innerHTML="Please Enter A Username !";
    }
    else
    {
        var ajax=new XMLHttpRequest();

        ajax.onreadystatechange=function(){
            if(ajax.readyState == 4 && ajax.status == 200)
            {
                if(ajax.responseText == 1)
                {
                    document.getElementById("errorUsername").innerHTML="Username Already Exists !";
                }
                else if(ajax.responseText == 0)
                {
                    document.getElementById("errorUsername").innerHTML="";
                }
            }
        };

        ajax.open("GET", "control_logic/checkusername.php?username=" + text, true);
        ajax.send();
    }
}

function checkPassword()
{
    var text1=document.getElementById("password").value;
    var text2=document.getElementById("repeatPassword").value;

    if(text1 == "")
    {
        document.getElementById("errorPassword").innerHTML="Please Enter A Password !";
    }
    else if(text1.length < 8)
    {
        document.getElementById("errorPassword").innerHTML="Password Should Be Minimum Of 8 Characters !";
    }
    else if(text2 != "" && text1 != text2)
    {
        document.getElementById("errorRepeatPassword").innerHTML="Passwords Do Not Match !";
    }
    else
    {
        document.getElementById("errorPassword").innerHTML="";
        document.getElementById("errorRepeatPassword").innerHTML="";
    }
}

function checkRepeatPassword()
{
    var text1=document.getElementById("password").value;
    var text2=document.getElementById("repeatPassword").value;

    if(text2 == "")
    {
        document.getElementById("errorRepeatPassword").innerHTML="Please Enter The Password Again !";
    }
    else if(text2.length < 8)
    {
        document.getElementById("errorRepeatPassword").innerHTML="Password Should Be Minimum Of 8 Characters !";
    }
    else if(text1 != text2)
    {
        document.getElementById("errorRepeatPassword").innerHTML="Passwords Do Not Match !";
    }
    else
    {
        document.getElementById("errorRepeatPassword").innerHTML="";
    }
}
