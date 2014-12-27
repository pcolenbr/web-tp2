$(function() {
		$('.testar').click(function(event) {
			$.post('http://localhost/tp2/api/index.php', {
			//$.post('http://cardapio.dreamt.com.br/climbapp/index.php', {
				"ident" : "get_instituicao",
				"id" : "1"
			}, function(response) {
				console.log(response);
				var json = $.parseJSON(response);
			});

		});
});