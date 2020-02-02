    /*
    * Creazione script per gestire feedback all'utente nel momento in cui fa click su "To order" oppure "Manage wishlist"
    * */
    $(document).ready(function() {
        var items = location.search.substr(1).split("&");
        var getParam = items[0].split("=")[1];
        document.getElementById("homeLbl").setAttribute("class","nav-item");
        document.getElementById("findLbl").setAttribute("class","nav-item");

        if(getParam == "order"){
            $("#ordTitle").css("border-bottom","solid 1px");
            $("#ordTitle").css("border-color","#e1aa26");
            $("#wlTitle").css("border-bottom","none");
        }else if(getParam == "wlist"){
            $("#wlTitle").css("border-bottom","solid 1px");
            $("#wlTitle").css("border-color","#e1aa26");
            $("#ordTitle").css("border-bottom","none");
        }else{
            $("#ordTitle").css("border-bottom","solid 1px");
            $("#ordTitle").css("border-color","#e1aa26");
            $("#wlTitle").css("border-bottom","none");
        }
    });

    /*
    * Invio dati asincrono per inserimento email nelle newsLetter
    * */
    function sendEmailNl(){
        if($("#emailNews").val()){
            if(validateEmail($("#emailNews").val())){
                $.ajax({
                    url: "user/newsLetter_script.php",
                    type: "POST",
                    data: "email="+$("#emailNews").val(),
                    datatype: "json",
                    success: function () {
                        $("#formNl").html("&#10003");
                        $("#formNl").css("color","yellowgreen");
                        $("#formNl").css("font-size","2em");
                        $("#formNl").css("text-align","center");
                        $("#errorMsgNl").html("");
                    },
                    error: function () {
                        $("#errorMsgNl").html("Something gone wrong, try later!");
                    },
                });
            }else
                $("#errorMsgNl").html("Insert valid email address!");
        }else{
            $("#errorMsgNl").html("Insert valid email address!");
        }
    }

    /*
    * Espressione regolare per corretto inserimento email
    * */
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }