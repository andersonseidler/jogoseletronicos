const tbody = document.querySelector(".listar-jogos");
const cadForm = document.getElementById("cad-jogo-form");
const editForm = document.getElementById("edit-jogo-form");
const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
const msgAlertaErroEdit = document.getElementById("msgAlertaErroEdit");
const msgAlerta = document.getElementById("msgAlerta");
const cadModal = new bootstrap.Modal(document.getElementById("cadJogoModal"));
const editModal = new bootstrap.Modal(document.getElementById("editJogoModal"));

const listarJogos = async (pagina) => {
    const dados = await fetch("./list.php?pagina=" + pagina);
    const resposta = await dados.text();
    tbody.innerHTML = resposta;
}

listarJogos(1);

cadForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    
    document.getElementById("cad-jogo-btn").value = "Salvando...";

    if(document.getElementById("nome").value === ""){
        msgAlertaErroCad.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>";
    }else if(document.getElementById("categoria").value === ""){
        msgAlertaErroCad.innerHTML = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher a categoria!</div>";
    }else{
        const dadosForm = new FormData(cadForm);
        dadosForm.append("add", 1);
        
        const dados = await fetch("cadastrar.php", {
            method: "POST",
            body: dadosForm,
        });
    
        const resposta = await dados.json();
        
        if(resposta['erro']){
            msgAlertaErroCad.innerHTML = resposta['msg'];
        }else{
            msgAlerta.innerHTML = resposta['msg'];
            cadForm.reset();
            cadModal.hide();
            listarJogos(1);
        }
    }    
    
    document.getElementById("cad-jogo-btn").value = "Cadastrar";
});

async function visJogo(id){
    const dados = await fetch('visualizar.php?id=' + id);
    const resposta = await dados.json();

    if(resposta['erro']){
        msgAlerta.innerHTML = resposta['msg'];
    }else{
        const visModal = new bootstrap.Modal(document.getElementById("visJogoModal"));
        visModal.show();

        document.getElementById("idJogo").innerHTML = resposta['dados'].id;
        document.getElementById("nomeJogo").innerHTML = resposta['dados'].nome;
        document.getElementById("categoriaJogo").innerHTML = resposta['dados'].categoria;
    }

}

async function editJogoDados(id){
    msgAlertaErroEdit.innerHTML = "";

    const dados = await fetch('visualizar.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);

    if(resposta['erro']){
        msgAlerta.innerHTML = resposta['msg'];
    }else{
        const editModal = new bootstrap.Modal(document.getElementById("editJogoModal"));
        editModal.show();
        document.getElementById("editid").value = resposta['dados'].id;
        document.getElementById("editnome").value = resposta['dados'].nome;
        document.getElementById("editcategoria").value = resposta['dados'].categoria;
    }
}

editForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    document.getElementById("edit-jogo-btn").value = "Salvando...";

    const dadosForm = new FormData(editForm);
    //console.log(dadosForm);

    const dados = await fetch("editar.php", {
        method: "POST",
        body:dadosForm
    });

    const resposta = await dados.json();
    //console.log(resposta);

    if(resposta['erro']){
        msgAlertaErroEdit.innerHTML = resposta['msg'];
    }else{
        msgAlertaErroEdit.innerHTML = resposta['msg'];
        listarJogos(1);
    }

    document.getElementById("edit-jogo-btn").value = "Salvar";
});

async function apagarJogoDados(id) {

    var confirmar = confirm("Tem certeza que deseja excluir o registro selecionado?");

    if(confirmar == true){
        const dados = await fetch('apagar.php?id=' + id);

        const resposta = await dados.json();
        if (resposta['erro']) {
            msgAlerta.innerHTML = resposta['msg'];
        } else {
            msgAlerta.innerHTML = resposta['msg'];
            listarJogos(1);
        }
    }    

}