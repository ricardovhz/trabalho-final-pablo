var lib = {
	url: "engine.php",

	send: function(data, callback) {
		$.post(lib.url, data, "json")
			.done(function(result) {
				if (callback) {
					callback(result);
				}
			});

	},

	sendAction: function(data, action, callback) {
		data.action = action;
		this.send(data,callback);
	},

	obterVendedorLogado: function(callback) {
		this.sendAction({},"vendedor_logado", callback);
	},


	obterVendas: function(callback) {
		this.sendAction({},"vendas_logado", callback);
	},
	obterPessoas: function(callback) {
		this.sendAction({},"obter_pessoas", callback);
	},
	obterVeiculos: function(callback) {
		this.sendAction({},"obter_veiculos", callback);
	}
}
