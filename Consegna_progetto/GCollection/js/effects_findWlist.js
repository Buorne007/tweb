
    /*
    * All'avvio della pagina viene settato il giusto CSS per le voci "home" e "find wishlist".
    * Vengono nascoste le informazioni inerenti al drag&drop.
    * Gestito il btn Search e le casistiche dell'errore.
    * */
    $(document).ready(function() {
        document.getElementById("homeLbl").setAttribute("class","nav-item");
        document.getElementById("findLbl").setAttribute("class","nav-item active");
        $("#containerImgSc").css("visibility","hidden");
        $("#istructions").css("visibility","hidden");
            $("#btnSearch").click(function () {
            var usrName = $("#usrnameFind").val();
            $(".singleItem").remove();
            if(usrName == "" || usrName == null)
                $("#errSpace").html("Username empty or wrong");
            else{
                $("#errSpace").html("");
                getItemsWlistFromUser(usrName);
            }
        });
    });

    /*
    * Inserito effetto hover sui div dei prodotti.
    * Presente ma non usata per poca compatibilità con jqueryUI
    * */
    function productsDiv(){
        $(".prod").mouseover(function () {
            $(this).delay("slow").css("box-shadow","5px 5px 10px #88888888");
        });

        $(".prod").mouseout(function () {
            $(this).delay("slow").css("box-shadow","none");
        });
    }

    /*
    * Dato il nome di un prodtto ne ritorna tutte le informazioni legate.
    * */
    function getInfoProd(name){
        $.ajax({
            url: "products/getInfoProductFromName.php",
            type: "POST",
            data: "nomeItem=" + name,
            datatype: "json",
            success: function (data) {
                createProductsDOM(data);
                $(".prod").draggable({ revert: true }); //Ritorna alla posizione iniziale
                //productsDiv();
            },
            error: function () {
                $("#errSpace").html("An error occurred, check the username");
            },
        });
    }

    /*
    * Dato username di un utente, si ritorna il json della sua wishlist.
    * Ogni oggetto sarà draggable verso un oggetto droppable.
    * */
    function getItemsWlistFromUser(usr) {
        $.ajax({
            url: "products/getListItemsWlistFromUser.php",
            type: "POST",
            data: "usrName=" + usr,
            datatype: "json",
            success: function (data) {
                //console.log(data);
                if(JSON.parse(data).length == 0){
                    $("#containerImgSc").css("visibility","hidden");
                    $("#noRes").html("Any products in wishlist");
                    $("#istructions").css("visibility","hidden");
                }else{
                    $("#noRes").html("");
                    $("#containerImgSc").css("visibility","visible");
                    $("#istructions").css("visibility","visible");
                    $("#imgSc").fadeOut(500);
                    $("#imgSc").fadeIn(500);
                    $("#imgSc").fadeOut(500);
                    $("#imgSc").fadeIn(500);
                    //console.log(data);
                    var list = JSON.parse(data);
                    for(var i = 0; i < list.length; i++){
                        getInfoProd(list[i][0]);
                    }
                    //Settaggio droppable + modal di conferma
                    $("#containerImgSc").droppable({
                        drop: function( event, ui ) {
                            $("#responseSpace").html("");
                            var obj = ui.draggable;
                            var info = obj[0].childNodes[2].textContent;
                            $("#bt").click(); //to show modal
                            $("#nameItem").html("Name: "+info.split(",")[0]);
                            $("#priceItem").html("Price: "+info.split(",")[6]+".00 &euro;");
                            $("#colorItem").html("Color: "+info.split(",")[4]);
                            $("#btnConfirm").click(function () {
                                var size = $("#taglia").children("option:selected").val();
                                sendToShopcart(info.split(",")[0],size);
                            });
                        }
                    });
                }
            },
            error: function () {
                $("#containerImgSc").css("visibility","hidden");
                $("#noRes").html("");
                $("#istructions").css("visibility","hidden");
               $("#errSpace").html("An error occurred, check the username");
            },
        });
    }


    /*
    * Creazione dinamica dei div contenenti le immagini dei prodotti in base alla categoria presente nell'URL.
    * data è la risposta JSON allo script php infoProducts.
    * */
    function createProductsDOM(data){
        var obj = JSON.parse(data);
        var container = document.getElementById("containerItems");
        var anchor = document.createElement("a");
        var firstDiv = document.createElement("div");
        var nomeProd = document.createElement("p");
        var imgProd = document.createElement("img");
        var otherInfo = document.createElement("div");
        var link = "./details.php?nome="+obj[0]+"&cat="+obj[1];

        anchor.setAttribute("href",link);
        anchor.setAttribute("class","singleItem");
        firstDiv.setAttribute("class","prod ui-widget-content");
        nomeProd.setAttribute("id","nomeProd");
        nomeProd.innerHTML = obj[0];
        imgProd.setAttribute("class","imgProd");
        imgProd.setAttribute("src",obj[2]);
        imgProd.setAttribute("alt",obj[0]);
        otherInfo.setAttribute("id","infos");
        otherInfo.innerHTML = obj[0]+","+obj[1]+","+obj[2]+","+obj[3]+","+obj[4]+","+obj[5]+","+obj[6];

        container.appendChild(anchor);
        anchor.appendChild(firstDiv);
        firstDiv.appendChild(nomeProd);
        firstDiv.appendChild(imgProd);
        firstDiv.appendChild(otherInfo);
    }

    /*
    * Chiamata asincrona per add item nel proprio carrello.
    * Deriva dal click di conferma del model.
    * */
    function sendToShopcart(nameItem, size){
        var item = {
            idCar: $("#idCar").html(),
            nomeProd: nameItem,
            taglia: size
        };
        $.ajax({
            url: "products/addCarrello_script.php",
            type: "POST",
            data: "dataCar="+JSON.stringify(item),
            datatype: "json",
            success: function () {
                $("#closeModal").click();
                $("#responseSpace").html("Item added correctly!");
            },
            error: function () {
                $("#msgOk").html("");
                $("#msgErr").css("color","red");
                $("#msgErr").html("Something gone wrong, try later!");
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