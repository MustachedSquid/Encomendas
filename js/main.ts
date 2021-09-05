
function createNumberSelect(){

    let nSelectNode = document.createElement("select");
    for (let i = 0; i <= 120; i++) {

        let opt = document.createElement("option")
        opt.value = ""+i;
        opt.text = ""+i;
        nSelectNode.appendChild(opt);
    }

    nSelectNode.name="cNum[]";
    return nSelectNode;

}

function createBolosSelect(){

    let bSelectNode = document.createElement("select");

    //DF
    let opt = document.createElement("option")
    opt.value = "Doce Fino";
    opt.text = "Doce Fino";
    bSelectNode.appendChild(opt);
    //Q
    opt = document.createElement("option")
    opt.value = "Queijinhos";
    opt.text = "Queijinhos";
    bSelectNode.appendChild(opt);
    //ANI
    opt = document.createElement("option")
    opt.value = "Animais";
    opt.text = "Animais";
    bSelectNode.appendChild(opt);
    //DR
    opt = document.createElement("option")
    opt.value = "D. Rodrigo";
    opt.text = "D. Rodrigo";
    bSelectNode.appendChild(opt);
    //M
    opt = document.createElement("option")
    opt.value = "Morgadinho";
    opt.text = "Morgadinho";
    bSelectNode.appendChild(opt);
    //P
    opt = document.createElement("option")
    opt.value = "Papo-seco";
    opt.text = "Papo-seco";
    bSelectNode.appendChild(opt);
    //ALM
    opt = document.createElement("option")
    opt.value = "Almendrado";
    opt.text = "Almendrado";
    bSelectNode.appendChild(opt);

    //Bolos grandes
    opt = document.createElement("option")
    opt.value = "KG Doce Fino";
    opt.text = "KG Doce Fino";
    bSelectNode.appendChild(opt);
    opt = document.createElement("option")
    opt.value = "KG Morgado";
    opt.text = "KG Morgado";
    bSelectNode.appendChild(opt);
    opt = document.createElement("option")
    opt.value = "KG Torta Doce Fino";
    opt.text = "KG Torta Doce Fino";
    bSelectNode.appendChild(opt);
    opt = document.createElement("option")
    opt.value = "KG Massa";
    opt.text = "KG Massa";
    bSelectNode.appendChild(opt);
    opt = document.createElement("option")
    opt.value = "KG Fios de Ovos";
    opt.text = "KG Fios de Ovos";
    bSelectNode.appendChild(opt);

    bSelectNode.name="cBolo[]";
    return bSelectNode;

}

function addRow(){

    let form = document.getElementById("encomendaaddform") as HTMLFormElement;
    //let formInnerHtml = form.innerHTML;
    //let end = document.getElementById("end") as HTMLInputElement;
    //let input = '<input type="text" name="cbolo" class="cbolo">';
    let br = document.createElement("br")
    let inputNode = document.createElement("input")
    inputNode.name = "cCom[]";
    inputNode.type = "text";
    inputNode.className = "cbolo"


    form.appendChild(createNumberSelect());
    form.appendChild(createBolosSelect());
    form.appendChild(br);
    form.appendChild(inputNode);
    form.appendChild(br);


}

function main(){

    let botAdd = document.getElementById("add") as HTMLButtonElement;

    botAdd.addEventListener("click",addRow);

}

window.addEventListener("load", main);