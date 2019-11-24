var assoc = [1,2,3,0,0,4,5,0,0,6,7,0,0,8,9,10];
$(document).ready(function(){

    //Vettore per evitare swap riga precedente
    for(i = 1; i < 17; i++){
        if(i == 16)
            $("#puzzlearea").append("<div class=sqr id=nothing></div>");
        else
            $( "#puzzlearea" ).append("<div class=sqr id=num"+i+">"+i+"</div>");
    }

    $( ".sqr" ).on({
        mouseenter: function () {
            $(this).css("background-color", "yellow");
        },
        mouseleave: function () {
            $(this).css("background-color", "red");
        },
        click: function () {
            fun(this);
            //Numero indice del div clicked
            /*index = $(this).text();
            vectPrev = $(this).prevAll();
            vectNext = $(this).nextAll();


            //NB: devo modificare il DOM
            sxId = $(vectPrev[0]).attr("id");
            dxId = $(vectNext[0]).attr("id");
            upId = $(vectPrev[3]).attr("id");
            downId = $(vectNext[3]).attr("id");*/



            /* alert("sx: "+sxId);
             alert("dx: "+dxId);
             alert("up: "+upId);
             alert("down: "+downId);


             if(sxId == "num16" && (vectIndex[$("#"+sxId).index()] != vectIndex[$(this).index()]))
                 swapsx(this,sxId);
             else if(dxId == "num16" && (vectIndex[$("#"+dxId).index()] != vectIndex[$(this).index()]))
                 swapdx(this,dxId);
             else if(upId == "num16")
                 swapup(this,upId);
             else
                 swapdown(this,downId);*/


            /*if(dxId == "num16" || sxId == "num16" || upId == "num16" || downId == "num16"){

                $(this).fadeOut("slow",function () {
                    //alert("mi muovo e sono: "+$(this).text()+$(this).attr("id"));
                    test($(this).text(),$(this).attr("id"));
                    $(this).attr("id","num16");
                    $(this).text("");
                    $(this).fadeIn("Slow");

                });


               /* $(this).fadeIn("slow");
                $("#num16").fadeIn("slow");




                $("#num16").animate({top: toMoveOffset.top, left: toMoveOffset.left}, "slow");

            }*/

            /* alert(dxId);
             alert(sx.text());
             alert(upDiv.text());
             alert(downDiv.text());*/




            /*alert($(this).next());
            if($(this).next().text() == "")
                alert("sdsgdsdg");


            //Reperimento cella sopra
            newIndex = "num"+(index-4);
            index2 = $("#"+newIndex).text();
            alert("Dooooopo: "+index2);*/

            //Reperimento cella sotto
        }

    });

});

function swapsx(first,second){
    $(first).fadeOut("fast");
    $("#"+second).fadeOut("fast");
    $("#"+second).insertAfter(first);
    $(first).fadeIn("fast");
    $("#"+second).fadeIn("fast");

}

function swapdx(first,second){
    $(first).fadeOut("fast");
    $("#"+second).fadeOut("fast");
    $("#"+second).insertBefore(first);
    $(first).fadeIn("fast");
    $("#"+second).fadeIn("fast");
}

function swapup(first,second){



}

function swapdown(first,second){
    //Indice a div prima di clicked
    idPrevUp = $(first).index()-1;
    //alert("Num ID prec clicked: "+idPrevUp + " " + $("#num"+(idPrevUp+1)).attr("id"));

    //Indice a div prima di empty
    idPrevDown = $("#"+second).index()-1;
    //alert("Num ID prec empty: "+idPrevDown + " " + $("#num"+(idPrevDown+1)).attr("id"));


    elem = $("#num16").index()-1; //indice prev emty
    //alert("SONO BUOTO: "+$("#num16").attr("id"));

    $("#num16").insertBefore($(first));


    $("#num"+(elem+1)).insertAfter($("#num"+($("#num16").index()+1)));




    //alert($("#"+second).index()+1);
}

function fun(ob){ //passo l'oggetto sulla quale ho cliccato
    //se quello sopra o quello sotto della quale ho cliccato e' il div vuoto lo sposto
    if($(ob).prev().prev().prev().prev().attr('id') == "nothing" || $(ob).next().next().next().next().attr('id') == "nothing"){
        if($("#nothing").index()!=0)
            swap1(ob)
        else
            swap2(ob)
    }
    //se quello a destra e' il div vuoto (verifico anche con assoc che il div vuoto sia a sinistra ma nella riga sotto) lo sposto
    else if(($(ob).next().attr('id') == "nothing") && (assoc[parseInt($("#nothing").index())] != assoc[parseInt($(ob).index())]))
        swap1(ob)
    //se quello a sinistra e' il div vuoto (verifico anche con assoc che il div vuoto sia a destra ma nella riga sopra) lo sposto
    else if(($(ob).prev().attr('id') == "nothing") && (assoc[parseInt($("#nothing").index())] != assoc[parseInt($(ob).index())])){	 //&& (as[parseInt($("#nothing").index())]!=2 || as[parseInt($(ob).index())]!=2)){
        if($("#nothing").index()!=0)
            swap1(ob)
        else
            $("#nothing").insertAfter($(ob));
        //se e' il primo div non posso eseguire prev() allora eseguo insAfter

    }
    //}
}

function shuf(){ //mischio la matrice
    //vettore con le posizioni possibili
    var pos=["up","down","left","right"];
    var n=Math.floor(Math.random()*(100-10)+10), location;
    for (var i=0; i<n; i++){
        location=Math.floor(Math.random()); //scelgo se destra o sinistra
        if(location==0)
        //chiamo la swap1 passando come parametro l'oggetto DOM preso dal metodo get_ob al quale passo una posizione random, in questo modo swappo con random la posizione ovvero "up, down, left, right", la direzione ovvero "sinistra e destra", il numero di volte complessivo di swap con il for
            swap1(get_ob(pos[Math.floor(Math.random()*3)]));
        else
            swap2(get_ob(pos[Math.floor(Math.random()*3)]));
    }
}

function get_ob(p){
    if(p=="up"){
        //se non ho sforato andando troppo indietro nel DOM
        if($("#nothing").prev().prev().prev().prev().parent().attr('id')=="puzzlearea")
            return $("#nothing").prev().prev().prev().prev();

    }
    if(p=="down"){
        if($("#nothing").next().next().next().next().parent().attr('id')=="puzzlearea")
            return $("#nothing").next().next().next().next();
    }
    if(p=="left"){
        if($("#nothing").index()!=0)
            return $("#nothing").prev();
    }
    if(p=="right"){
        if($("#nothing").index()!=15)
            return $("#nothing").next()
    }
}

function swap1(ob){
    aj=$("#nothing").prev();
    $("#nothing").insertBefore($(ob));
    $(ob).insertAfter($(aj));
}

function swap2(ob){
    aj=$("#nothing").next();
    $("#nothing").insertAfter($(ob));
    $(ob).insertBefore($(aj));
}