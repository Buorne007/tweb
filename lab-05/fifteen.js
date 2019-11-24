/*A pagina pronta si crea dinamicamente una matrice 4x4 di div, tutti quanti cliccabili.
* Sono stati inseriti controlli sulla correttezza del gioco e sui vari effetti.*/
$(document).ready(function(){
    //Vettore per evitare swap riga precedente
    var vectIndex = [1,2,3,0,0,4,5,0,0,6,7,0,0,8,9,10];
    //Vettore sul quale fare shuffle per generare matrice casuale
    var myArray = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16];

    shuffle(myArray);
    createMatrix(myArray);
    setbg();

    //Settaggio degli eventi sui div della matrice
    $( ".sqr" ).on({
        mouseenter: function () {
            if(chechNeighbors($(this)) == 1)
                $(this).css("color", "red");
        },
        mouseleave: function () {
            $(this).css("color", "black");
        },
        click: function () {

            //Vettore per conoscere tutti i precedenti e i successivi
            vectPrev = $(this).prevAll();
            vectNext = $(this).nextAll();

            //Reperimento ID dei div posizionati up,down,sz,dxå
            sxId = $(vectPrev[0]).attr("id");
            dxId = $(vectNext[0]).attr("id");
            upId = $(vectPrev[3]).attr("id");
            downId = $(vectNext[3]).attr("id");

            //Controllo possibilità di movimento (escludendo vicino in riga superiore)
            if(sxId == "num16" && (vectIndex[$("#"+sxId).index()] != vectIndex[$(this).index()])) {
                swapsx(this, sxId);
                checkResult();
            }else if(dxId == "num16" && (vectIndex[$("#"+dxId).index()] != vectIndex[$(this).index()])){
                swapdx(this,dxId);
                checkResult();
            }
            else if(upId == "num16"){
                swapup(this,upId);
                checkResult();
            }
            else if(downId == "num16"){
                swapdown(this,downId);
                checkResult();
            }
        }
    });

    //Definizione eventi per btn shuffle
    $("#shufflebutton").on({
        mouseenter: function () {
            //$(this).animate({width: "300px"},"slow");
        },
        mouseleave: function () {

        },
        click: function () {
            location.reload();
            //shuffle(myArray);
            //createMatrix(myArray);
            //animation();

            //createRandomArray();
        }
    });

});

//NB: al div clicked (first) dev'essere settato il colore nero altrimenti rimane settato a rosso
//Movimento sx del div cliccato. Modifica del DOM
function swapsx(first,second){
    $("#"+second).insertAfter(first);
    $(first).css("color", "black");
}

//Movimento dx del div cliccato. Modifica del DOM
function swapdx(first,second){
    $(first).css("color", "black");
    $("#"+second).insertBefore(first);
}

//Movimento up del div cliccato. Modifica del DOM
function swapup(first,second){
    objPrevClicked = $(first).prev();
    objPrevEmpty = $("#"+second).prev();
    objEmpty = $("#"+second);
    objClicked = first;
    $(first).css("color", "black");
    if($(objEmpty).index() == 0){
        nextCliecked = $(objEmpty).next();
        $(objEmpty).insertAfter(objClicked);
        $(objClicked).insertBefore($(nextCliecked));

    }else {
        $(objEmpty).insertBefore(objClicked);
        $(objClicked).insertAfter(objPrevEmpty);
    }
}

//Movimento down del div cliccato. Modifica del DOM
function swapdown(first,second) {
    $(first).css("color", "black");

    objPrevClicked = $(first).prev();
    objPrevEmpty = $("#" + second).prev();
    objEmpty = $("#" + second);
    objClicked = first;

    $(objEmpty).insertBefore(objClicked);
    $(objClicked).insertAfter(objPrevEmpty);
}

//Settaggio dell'immagine di sfondo in modo da scompattarla nei vari div della matrice
function setbg(){
    y = 0;
        for(i = 1; i < 16;){
            for(k = 0; k > -400 && i < 16; k -= 100,i++){
                $("#num"+i).css({
                    "background-image":"url(bgmatdes.png)",
                    "background-position": k+"px "+y+"px"
                });
            }
            if(y == 0){
                y = 300;
            }else
                y -= 100;
        }
}

//Controlla se un determinato div ha vicino (su,giu,dx,sx) il div vuoto, ovvero se può muoversi in qualche direzione.
function chechNeighbors(hovered){
    vectPrev = $(hovered).prevAll();
    vectNext = $(hovered).nextAll();


    //NB: devo modificare il DOM
    sxId = $(vectPrev[0]).attr("id");
    dxId = $(vectNext[0]).attr("id");
    upId = $(vectPrev[3]).attr("id");
    downId = $(vectNext[3]).attr("id");

    if(sxId == "num16" || dxId == "num16" || upId == "num16" || downId == "num16"){
        return 1;
    }else
        return 0;
}

function animation() {
    $("#puzzlearea").animate(
        { deg: 0 },
        {
            duration: 600,
            step: function(now) {
                $(this).css({ transform: 'rotate(' + now + 'deg)' });
            }
        }
    );
    $("#puzzlearea").animate(
        { deg: 360 },
        {
            duration: 600,
            step: function(now) {
                $(this).css({ transform: 'rotate(' + now + 'deg)' });
            }
        }
    );
}

//Creazione dinamica della matrice di div
function createMatrix(arr){
    $(".sqr").remove();
    for(i = 0; i < 16; i++){
        if(arr[i] == 16)
            $("#puzzlearea").append("<div class=sqr id=num"+arr[i]+"></div>");
        else
            $("#puzzlearea").append("<div class=sqr id=num"+arr[i]+">"+arr[i]+"</div>");
    }
    setbg();

}

//Dato un vettore, fa swap del contenuto delle celle in posizione i e j(randomica)
function shuffle(a) {
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}

//Ritorna true se la disposizione di div della matrie è corretta
function checkResult(){
    kids = $("#puzzlearea").find(".sqr");
    boost = true;
    for (i = 0; i < kids.length && boost; i++){
        if($(kids[i]).text() != i)
            boost = false;
    }
    if(boost)
        animation();
}