$(".alert-success").fadeTo(1000, 500).slideUp(300, function() {
    $(".alert-success").alert('close');
});
$(".alert-danger").fadeTo(1000, 500).slideUp(300, function() {
    $(".alert-danger").alert('close');
});
contTipo3 = $('.contadorTipo3').length; //conta quantos radio buttons existe em cada pergunta
contTipo4 = $('.contadorTipo4').length; //conta quantos checkboxes existe em cada pergunta
document.getElementById('valorTipo3').value = contTipo3; //passa o valor para o formulario
document.getElementById('valorTipo4').value = contTipo4;

function removerOpcao(idForm, idPerg, idopcao, tipo) {
    if (tipo == 3) {
        if (contTipo3 == 1) {
            alert('A pergunta ficará sem opções para a resposta');
        } else {
            window.location.href = "assets/php/editaFormulario.php?idForm=" + idForm + "&idPerg=" + idPerg + "&idopcao" + idopcao + "&deleteOp=" + idopcao;
        }
    } else if (tipo == 4) {
        if (contTipo4 == 1) {
            alert('A pergunta ficará sem opções para a resposta');
        } else {
            window.location.href = "assets/php/editaFormulario.php?idForm=" + idForm + "&idPerg=" + idPerg + "&idopcao" + idopcao + "&deleteOp=" + idopcao;
        }
    }
}

function removerPergunta(idForm, idPerg) {
    window.location.href = "assets/php/editaFormulario.php?idForm=" + idForm + "&idPerg=" + idPerg + "&deletePerg=" + idPerg;
}

function addOpcao(idForm, idPerg, tipo) {
    if (tipo == 3) {
        $('.radioButton' + idPerg).show();
        var div = $('.radioButton' + idPerg);
        div.html('');
        var nomeOpcao = '<input type="radio">';
        div.append(nomeOpcao);
        var idForm = '<input type="hidden" name="idForm.value" id="idForm.value">';
        div.append(idForm);
        var idPerg = '<input type="hidden" name="idPerg" id="idPerg" value="' + idPerg + '">';
        div.append(idPerg);
        var frase = '<input type="name" name="opcao" id="opcao" class="contadorTipo3 inputRadio" maxlength="45">';
        div.append(frase);
        var pesos = '<select type="name" name="peso" class="form-control input-md"><option value="">Peso</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
        div.append(pesos);
        var salvar = '<input type="button" class="btn btn-sm btnGerdau" value="Salvar" onclick="adicionaOpcao(idForm.value, idPerg.value, opcao.value, peso.value);">';
        div.append(salvar);
        var apagar = '<input type="button" class="btn btn-sm btnGerdau" value="x">';
        div.append(apagar);
    } else if (tipo == 4) {
        $('.checkBox' + idPerg).show();
        var div = $('.checkBox' + idPerg);
        div.html('');
        var nomeOpcao = '<input type="checkbox">';
        div.append(nomeOpcao);
        var idForm = '<input type="hidden" name="idForm.value" id="idForm.value">';
        div.append(idForm);
        var idPerg = '<input type="hidden" name="idPerg" id="idPerg" value="' + idPerg + '">';
        div.append(idPerg);
        var frase = '<input type="name" name="opcao" id="opcao" class="contadorTipo4 inputCheckbox" maxlength="45">';
        div.append(frase);
        var pesos = '<select type="name" name="peso" class="form-control input-md"><option value="">Peso</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
        div.append(pesos);
        var salvar = '<input type="button" class="btn btn-sm btnGerdau" value="Salvar" onclick="adicionaOpcao(idForm.value, idPerg.value, opcao.value, peso.value);">';
        div.append(salvar);
        var apagar = '<input type="button" class="btn btn-sm btnGerdau" value="x">';
        div.append(apagar);
    }
}

function adicionaOpcao(idForm, idPerg, opcao, peso) {
    window.location.href = "assets/php/editaFormulario.php?idForm=" + idForm + "&idPerg=" + idPerg + "&opcao=" + opcao + "&peso=" + peso + "&insertOp=" + peso;
}

function insertPerg() {
    $('#pergOculta').show();
}
$(document).ready(function() {
    $('.optionOculto').hide();
    $('.tipo').change(function() {
        var div = $('.optionOculto');
        var divResposta = $('.respostaOculta');
        if ($('.tipo').val() == 1) {
            $('.optionOculto').hide();
            $('.respostaOculta').show();
            var tipo1 = '<input type="text" name="teste" id="resposta" class="form-control input-md" placeholder="Campo de exemplo">';
            divResposta.append(tipo1);
        } else if ($('.tipo').val() == 2) {
            $('.optionOculto').hide();
            $('.respostaOculta').show();
            var tipo2 = '<textarea rows="4" cols="50" id="resposta" class="form-control input-md" placeholder="Campo de exemplo"></textarea>';
            divResposta.append(tipo2);
        } else if ($('.tipo').val() == 3) {
            if (document.getElementById('tipoOpcao[1]')) {
                for (var i = 1; document.getElementById('tipoOpcao[' + i + ']'); i++) {
                    document.getElementById('tipoOpcao[' + i + ']').type = 'radio';
                }
            } else {
                $('.respostaOculta').hide();
                $('.optionOculto').show();
                var value = 1;
                var nomeOpcao = '<input type="text" name="opcao[]' + value + '" class="form-control formopcoes" id="input' + value + '" placeholder="Adicionar opção" maxlength="45" required></div>';
                var frase = '<div class="respDivs" id="resp' + value + '"><input id="tipoOpcao[' + value + ']" type="radio" name="teste" value="' + value + '"> ' + nomeOpcao;
                div.append(frase);
                var pesos = '<select type="name" id="resposta" name="peso[]" class="form-control input-md"><option value="">Peso</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
                div.append(pesos);
                value++;
            }
        } else if ($('.tipo').val() == 4) {
            if (document.getElementById('tipoOpcao[1]')) {
                for (var i = 1; document.getElementById('tipoOpcao[' + i + ']'); i++) {
                    document.getElementById('tipoOpcao[' + i + ']').type = 'checkbox';
                }
            } else {
                $('.respostaOculta').hide();
                $('.optionOculto').show();
                var value = 1;
                var nomeOpcao = '<input type="text" name="opcao[]' + value + '" class="formopcoes" id="input' + value + '" placeholder="Adicionar opção" maxlength="45" required> </div>';
                var frase = '<div class="respDivs" id="resp' + value + '"><input id="tipoOpcao[' + value + ']" type="checkbox" value="' + value + '"> ' + nomeOpcao;
                div.append(frase);
                var pesos = '<select type="name" id="resposta" name="peso[]" class="form-control input-md"><option value="">Peso</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
                div.append(pesos);
                value++;
            }
        }
    });
    var value = 2;
    $('#add').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var div = $('.optionOculto');
        if ($('.tipo').val() == '3') {
            var nomeOpcao = '<input type="text" name="opcao[]' + value + '" class="form-control formopcoes" id="input' + value + '" maxlength="45" placeholder="Adicionar opção" required> </div>';
            var frase = '<div class="respDivs" id="resp' + value + '"><input id="tipoOpcao[' + value + ']" type="radio" value="' + value + '"> ' + nomeOpcao;
            div.append(frase);
            var pesos = '<select type="name" id="resposta" name="peso[]" class="form-control input-md"><option value="">Peso</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
            div.append(pesos);
            value++;
        } else if ($('.tipo').val() == '4') {
            var nomeOpcao = '<input type="text" name="opcao[]' + value + '" class="form-control formopcoes" id="input' + value + '" placeholder="Adicionar opção" maxlength="45" required> </div>';
            var frase = '<div class="respDivs" id="resp' + value + '"><input id="tipoOpcao[' + value + ']" type="checkbox" value="' + value + '"> ' + nomeOpcao;
            div.append(frase);
            var pesos = '<select type="name" id="resposta" name="peso[]" class="form-control input-md"><option value="">Peso</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
            div.append(pesos);
            value++;
        }
    });
    $('#remove').click(function(e) { 
        if(value == 0){
            alert("Selecione uma opção");
            return;
        }
        value--;
        if($('#tipo').val() == '3' || $('#tipo').val() == '4'){
            $("#resp" + value).remove();
            $("#resposta" + value).remove();
        }
    });
});