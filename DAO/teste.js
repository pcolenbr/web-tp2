$(function() {
		$('.testar').click(function(event) {
			$.post('http://localhost/escalada/api_bd/index.php', {
			//$.post('http://cardapio.dreamt.com.br/climbapp/index.php', {
				"identificador" : "listar_exercicios",
				"lingua" : "1"
				
			}, function(response) {
				var json = $.parseJSON(response);
				
			});
		});
});