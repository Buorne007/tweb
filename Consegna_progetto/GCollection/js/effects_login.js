    /*
    * Gestione swapping tra form Login e Signin nella pagina login.php.
    * Al click di Signin in login.php viene creato dinamicamente il form tramite questa funzione.
    *
    * Per ritornare alla form di login viene usato un tag <a> con l'attributo href per aggiornare la pagina e tornare
    * alla forma originale con il login.
    * */
    $( document ).ready(function() {
        $("#switchSignin").click(function () {
            createFormSignin();
            $("#switchLogin").click(function () {
                window.location.href = "login.php";
            });
        });
    });

    /*
     * Funzione di creazione dinamica del form di login.
     */
    function createFormSignin() {
        var title = document.getElementById("titleForm");
        var form = document.getElementById("formLogin");
        var emailInput = document.createElement("input");
        var usrnameInput = document.createElement("input");
        var passwdInput = document.createElement("input");
        var passwdRepInput = document.createElement("input");
        var redir = document.createElement("span");

        redir.setAttribute("id","switchLogin");
        redir.innerHTML = "Login";

        emailInput.setAttribute("class","in");
        emailInput.setAttribute("type","email");
        emailInput.setAttribute("id","emailUsr");
        emailInput.setAttribute("name","email");
        emailInput.setAttribute("placeholder","E-mail1");
        emailInput.required = true;

        usrnameInput.setAttribute("class","in");
        usrnameInput.setAttribute("type","text");
        usrnameInput.setAttribute("id","userName");
        usrnameInput.setAttribute("name","userName");
        usrnameInput.setAttribute("placeholder","UserName");
        usrnameInput.required = true;

        passwdInput.setAttribute("class","in");
        passwdInput.setAttribute("type","password");
        passwdInput.setAttribute("id","passwdUsr");
        passwdInput.setAttribute("name","passwd");
        passwdInput.setAttribute("placeholder","Password");
        passwdInput.required = true;

        passwdRepInput.setAttribute("class","in");
        passwdRepInput.setAttribute("type","password");
        passwdRepInput.setAttribute("id","passwdUsrConf");
        passwdRepInput.setAttribute("name","passwdConf");
        passwdRepInput.setAttribute("placeholder","Repeat Password");
        passwdRepInput.required = true;

        form.replaceChild(usrnameInput, form.childNodes[5]);
        form.insertBefore(passwdInput, form.childNodes[7]);
        form.insertBefore(passwdRepInput, form.childNodes[8]);
        form.childNodes[9].childNodes[1].removeChild(form.childNodes[9].childNodes[1].childNodes[0]);

        document.getElementById("anchorLink").appendChild(redir);
        document.getElementById("btnSubmitLogin").innerText = "REGISTER";
        form.setAttribute("action","user/signin_script.php");
        title.innerHTML = "REGISTER";
    }
