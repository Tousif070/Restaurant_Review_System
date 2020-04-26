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
        console.log("hahahaha");
        document.getElementById("errorPassword").innerHTML="Password Should Be Minimum Of 8 Characters !";
    }
    else if(text2 != "" && text1 != text2)
    {
        document.getElementById("errorPassword").innerHTML="";
        document.getElementById("errorRepeatPassword").innerHTML="Passwords Do Not Match !";
    }
    else if(text1 == text2)
    {
        document.getElementById("errorPassword").innerHTML="";
        document.getElementById("errorRepeatPassword").innerHTML="";
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

function invalidCharacters()
{
    var validation=true;
    var text1=document.getElementById("username").value;
    var text2=document.getElementById("password").value;
    var text3=document.getElementById("repeatPassword").value;

    if(!checkForInvalidCharacters(text1))
    {
        document.getElementById("errorUsername").innerHTML="Username Contains Invalid Characters !";
        validation=false;
    }

    if(!checkForInvalidCharacters(text2))
    {
        document.getElementById("errorPassword").innerHTML="Password Contains Invalid Characters !";
        validation=false;
    }

    if(!checkForInvalidCharacters(text3))
    {
        document.getElementById("errorRepeatPassword").innerHTML="Password Contains Invalid Characters !";
        validation=false;
    }
    return validation;
}

function checkForInvalidCharacters(text)
{
    var letters=["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
    var found=true;

    for(i=0; i<text.length; i++)
    {
        found=false;
        for(j=0; j<letters.length; j++)
        {
            if(text[i] == letters[j])
            {
                found=true;
                break;
            }
        }
        if(!found)
        {
            break;
        }
    }

    return found; // IF TRUE, THEN IT MEANS THAT THERE ARE NO INVALID CHARACTERS. IF FALSE, THEN IT MEANS THAT THERE ARE INVALID CHARACTERS
}
