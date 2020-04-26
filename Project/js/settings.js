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
    else if(!checkForInvalidCharacters(password.value))
    {
        document.getElementById("errorPassword").innerHTML="Password Contains Invalid Characters !";
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
    else if(!checkForInvalidCharacters(repeatPassword.value))
    {
        document.getElementById("errorRepeatPassword").innerHTML="Password Contains Invalid Characters !";
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
