$(".alert-success").fadeTo(1000, 500).slideUp(300, function(){
	$(".alert-success").html('');
});
$(".alert-danger").fadeTo(1000, 500).slideUp(300, function(){
	$(".alert-danger").html('');
}); 


$(document).ready(function(){
	var value = 1;
	$('#add').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		var div = $('#divisao-form');
		if($('#tipo').val() == '3'){
			var nomeOpcao = '<input type="text" name="opcoes[]' + value +'" class="form-control formrespostas" id="input' + value + '" maxlength="45" placeholder="Insira as opções aqui" required> </div>';
			var frase = '<div class="respDivs" id="resp' + value + '"><input id="radio' + value + '" type="radio" value="' + value +'"> '+ nomeOpcao;
			div.append(frase);
			value++;
		} else if($('#tipo').val() == '4'){
			var nomeOpcao = '<input type="text" name="opcoes[]' + value +'" class="form-control formrespostas" id="input' + value + '" maxlength="45" placeholder="Insira as opções aqui" required> </div>';
			var frase = '<div class="respDivs" id="resp' + value + '"><input id="checkbox' + value + '" type="checkbox" value="' + value + '"> '+ nomeOpcao;
			div.append(frase);
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
		}
	});

	$(document).ready(function() {
		$('#inputOculto').hide();
		$('#tipo').change(function() {
			if ($('#tipo').val() == 3 || $('#tipo').val() == 4) {
				$('#inputOculto').show();
			} else {
				$('#inputOculto').hide();
			}
		});
	});

	$('#tipo').change(function(){
		var valor = $(this).val();
		var div = $('#divisao-form');
		switch(valor){
			case '1':
			div.html('<input type="text" name="teste" id="resposta" class="form-control input-md" placeholder="Campo de exemplo">');
			break;
			case '2':
			div.html('<textarea rows="4" cols="50" id="resposta" class="form-control input-md" placeholder="Campo de exemplo"></textarea>');
			break;
			case '3':
			value = 1;
			div.html('');
			var nomeOpcao = '<input type="text" name="opcoes[]' + value +'" class="form-control formrespostas" id="input' + value + '" maxlength="45" placeholder="Insira as opções aqui" required></div>';
			var frase = '<div class="respDivs" id="resp' + value + '"><input id="radio' + value + '" type="radio" name="teste" value="' + value +'"> '+ nomeOpcao;
			div.append(frase);
			value++;
			break;
			case '4':
			value = 1;
			div.html('');
			var nomeOpcao = '<input type="text" name="opcoes[]' + value +'" class="form-control formrespostas" id="input' + value + '" maxlength="45" placeholder="Insira as opções aqui" required></div>';
			var frase = '<div class="respDivs" id="resp' + value + '"><input id="checkbox' + value + '" type="checkbox" name="teste" value="' + value + '"> '+ nomeOpcao;
			div.append(frase);
			value++;
			break;
		}
	});
});