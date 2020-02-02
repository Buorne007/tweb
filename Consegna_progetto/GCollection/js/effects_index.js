    /*
    * Definizio istruzioni jquery per effetti su pagina index.
    * */
    $(document).ready(function() {
        var category = document.getElementById("catSpace").textContent;
        var res = category.split(" ");
        document.getElementById("homeLbl").setAttribute("class","nav-item active");
        document.getElementById("findLbl").setAttribute("class","nav-item");

        $.ajax({
            url: "products/getInfoProducts.php",
            type: "POST",
            data: "nameCat="+res[20], //Prendo da HTML ma css ha messo caratteri speciali nel testo(bootstrap)
            datatype: "json",
            success: function (data) {
                //console.log(data);
                createProductsDOM(data);
                productsDiv();
            },
            error: function () {
                var container = document.getElementById("container");
                var msgError = document.createElement("p");

                msgError.setAttribute("id","errorMsgNl");
                msgError.innerHTML = "Database error occurred, try later.";
                container.appendChild(msgError);
            },
        });
    });

    /*
    * Inserito effetto sui div dei prodotti.
    * */
    function productsDiv(){
        $(".prod").mouseover(function () {
            $(this).delay("slow").css("box-shadow","5px 5px 10px #88888888");
        })

        $(".prod").mouseout(function () {
            $(this).delay("slow").css("box-shadow","none");
        })
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
    * Creazione dinamica dei div contenenti le immagini dei prodotti in base alla categoria presente nell'URL.
    * data è la risposta JSON allo script php infoProducts.
    * */
    function createProductsDOM(data){
        var obj = JSON.parse(data);
        var container = document.getElementById("container");
        for(var i = 0; i < obj.length; i++){
            var anchor = document.createElement("a");
            var firstDiv = document.createElement("div");
            var nomeProd = document.createElement("p");
            var imgProd = document.createElement("img");

            var link = "./details.php?nome="+obj[i][0]+"&cat="+obj[i][1];
            anchor.setAttribute("href",link);
            firstDiv.setAttribute("class","prod");
            nomeProd.setAttribute("id","nomeProd");
            nomeProd.innerHTML = obj[i][0];
            imgProd.setAttribute("class","imgProd");
            imgProd.setAttribute("src",obj[i][2]);
            imgProd.setAttribute("alt",obj[i][0]);

            container.appendChild(anchor);
            anchor.appendChild(firstDiv);
            firstDiv.appendChild(nomeProd);
            firstDiv.appendChild(imgProd);
        }
    }