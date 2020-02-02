    /*
    * Setting listener click su btn AddToCard e funzioni associate e chiamata ajax per creazione dinamica
    * dei dettagli deò prodotto selezionato.
    * */
    $(document).ready(function() {
        //Nome prodotto preso da HTML
        var nomeItem = document.getElementById("nomeItem");
        document.getElementById("homeLbl").setAttribute("class","nav-item");
        document.getElementById("findLbl").setAttribute("class","nav-item");
        requstDetails(nomeItem);
        requestComments(nomeItem);

        $("#addCar").click(function () {
            sendToCarrello();
        });

        $("#addWl").click(function () {
            sendToWlist();
        });

        $("#sendComment").click(function () {
            sendToComment();
        });

    });

    /*
    * Richiesta asincrona per rilevazione dettagli singolo prodotto
    * */
    function requstDetails(nomeItem){
        $.ajax({
            url: "products/getInfoProductFromName.php",
            type: "POST",
            data: "nomeItem="+nomeItem.textContent,
            datatype: "json",
            success: function (data) {
                //console.log(data);
                createProductDetailsDOM(JSON.parse(data));
            },
            error: function () {
                var container = document.getElementById("confirmSpace");
                var msgError = document.createElement("p");

                msgError.setAttribute("id","errorMsgNl");
                container.innerHTML = "";
                msgError.innerHTML = "Database error occurred, try later.";
                container.appendChild(msgError);
            },
        });
    }

    /*
    * Richiesta asincrona per rilevazione di tutti i commenti legati al singolo prodotto
    * */
    function requestComments(nomeItem){
        $.ajax({
            url: "products/getCommentsFromItem.php",
            type: "POST",
            data: "nomeItem="+nomeItem.textContent,
            datatype: "json",
            success: function (data) {
                createCommentsDOM(JSON.parse(data));
            },
            error: function () {
                var container = document.getElementById("confirmSpace");
                var msgError = document.createElement("p");

                msgError.setAttribute("id","errorMsgNl");
                container.innerHTML = "";
                msgError.innerHTML = "Database error occurred, try later.";
                container.appendChild(msgError);
            },
        });
    }

    /*
    * Invio dati asincrono per inserimento del prodotto nel carrello dell'utente loggato
    * Gestiti alcuni effetti grafici.
    * */
    function sendToCarrello(){
        var item = {
            idCar: $("#idCar").html(),
            nomeProd:$("#nomeItem").text(),
            taglia:$("#taglia").children("option:selected").val()
        };
        $.ajax({
            url: "products/addCarrello_script.php",
            type: "POST",
            data: "dataCar="+JSON.stringify(item),
            datatype: "json",
            success: function () {
                $("#msgErr").html("");
                $("#msgOk").css("color","green");
                $("#msgOk").html("Add item correctly in shopping cart!");
                $("#confirmSpace").fadeOut(2000);
            },
            error: function () {
                $("#msgOk").html("");
                $("#msgError").css("color","red");
                $("#msgError").html("Something gone wrong, try later!");
                $("#confirmSpace").fadeOut(2000);
                $("#confirmSpace").fadeIn(2000);
                $("#confirmSpace").fadeOut(2000);
            },
        });
    }

    /*
    * Invio dati asincrono per inserimento del prodotto nella Wishlist dell'utente loggato.
    * Gestiti alcuni effetti grafici.
    * */
    function sendToWlist(){
        var item = {
            idWishlist: $("#idCar").html(),
            nomeProd:$("#nomeItem").text(),
        };
        //console.log(JSON.stringify(item));
        $.ajax({
            url: "products/addWlist_script.php",
            type: "POST",
            data: "dataWlist="+JSON.stringify(item),
            datatype: "json",
            success: function () {
                $("#confirmSpace").fadeOut(1000);
                $("#msgError").html("");
                $("#msgOk").css("color","green");
                $("#msgOk").html("Add item correctly in Wishlist!");
                $("#confirmSpace").fadeIn(1000);
            },
            error: function () {
                $("#msgOk").html("");
                $("#msgError").css("color","red");
                $("#msgError").html("Something gone wrong, try later!");
                $("#confirmSpace").fadeOut(2000);
                $("#confirmSpace").fadeIn(2000);
                $("#confirmSpace").fadeOut(2000);
            },
        });
    }

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


    /*
    * Invio dati asincrono per inserimento del commento nella tabella Commenti dell'utente loggato.
    * Gestiti alcuni effetti grafici.
    * */
    function sendToComment(){
        $("#errorMsgComment").html("");
        $("#errorMsgComment").fadeIn(2000);
        if($("#txtComment").val() == "") {
            $("#errorMsgComment").css("color","red");
            $("#errorMsgComment").html("The comment cannot be empty");
            $("#errorMsgComment").fadeOut(2000);
        }else{
            var comment = {
                idProdotto: $("#nomeItem").html(),
                testo: $("#txtComment").val(),
                username: $("#usName").html()
            };
            //console.log(JSON.stringify(comment));
            $.ajax({
                url: "products/addComment_script.php",
                type: "POST",
                data: "dataCom="+JSON.stringify(comment),
                datatype: "json",
                success: function () {
                    addCommentSlot(comment);
                    $("#errorMsgComment").css("color","green");
                    $("#errorMsgComment").html("The comment has been sent!");
                    $("#txtComment").val("");
                    $("#errorMsgComment").fadeOut(2000);
                },
                error: function () {
                    $("#errorMsgComment").css("color","red");
                    $("#errorMsgComment").html("Something gone wrong, try later!");
                    $("#errorMsgComment").fadeOut(2000);
                },
            });
        }
    }

    /*
    * Settaggio dinamico dei dettagli del prodotto selezionato.
    * Sufficiente cambiare il testo delle label inserite, escluso per l'immagine.
    * */
    function createProductDetailsDOM(data){
        var imgDetSpace = document.getElementById("detProd").childNodes[1];
        var imgDet = document.createElement("img");
        imgDet.setAttribute("src",data[2]);
        imgDet.setAttribute("alt",data[0]);
        imgDet.setAttribute("id","imgArt");
        imgDetSpace.html = "";
        imgDetSpace.appendChild(imgDet);

        document.getElementById("catSpace").innerHTML = data[1];
        document.getElementById("descSpace").innerHTML = data[3];
        document.getElementById("colSpace").innerHTML = data[4];
        document.getElementById("matSpace").innerHTML = data[5];
        document.getElementById("priceSpace").innerHTML = data[6]+".00 &euro;";
    }

    /*
    * Creazione dinamica dei commenti legati ad un prodotto specifico,
    * */
    function createCommentsDOM(data){
        var cmtSpace = document.getElementById("commentSpace");
        cmtSpace.innerText = "";
        var titleCommenSpace = document.createElement("div");
        var titleComment = document.createElement("h2");

        titleCommenSpace.setAttribute("class","col-sm-12 pull-left");
        titleCommenSpace.setAttribute("id","commentTitle");
        titleComment.innerHTML = "Commenti";
        titleCommenSpace.appendChild(titleComment);
        cmtSpace.appendChild(titleCommenSpace);

        for(var i = 0; i < data.length; i++) {
            var cmt = {
                testo: data[i][1],
                username: data[i][2]
            };
            addCommentSlot(cmt);
        }
    }

    /*
    * Gestione singola aggiunta di elemento
    * */
    function addCommentSlot(arrDet){
        var cmtSpace = document.getElementById("commentSpace");
        var singleComment = document.createElement("div");
        var nameSpace = document.createElement("div");
        var nameFrom = document.createElement("p");
        var txtSpace = document.createElement("div");
        var txt = document.createElement("p");

        singleComment.setAttribute("class","row");
        singleComment.setAttribute("id","singleComment");

        nameSpace.setAttribute("class","col-sm-12 pull-left");
        singleComment.appendChild(nameSpace);

        nameFrom.setAttribute("id","fromUsr");
        nameFrom.innerHTML = "From: "+ arrDet["username"];

        txtSpace.setAttribute("class","col-sm-8 pull-left");
        singleComment.appendChild(txtSpace);

        txt.innerHTML = arrDet["testo"];
        txtSpace.appendChild(txt);
        nameSpace.appendChild(nameFrom);

        cmtSpace.appendChild(singleComment);
    }