var lib = {
	url: "engine.php",
	parseDate: function(d) {
		var date = new Date();
		if (typeof(d) === "string") {
			date = new Date(Date.parse(d));
		} else {
			date = d;
		}
		var day = "00"+date.getUTCDate();
		var month = "00"+(date.getUTCMonth()+1);
		var year = "0000"+date.getUTCFullYear();
		return day.substring(day.length-2) + "/"+month.substring(month.length-2)+"/"+year.substring(year.length-4);
	},
	checkForMessages: function(selector) {
               if (location.search.length > 0) {
                       var search = location.search.substring(1).split("&");
                       if (search.length > 0) {
                               var classAlert = "";
                               var message = "";
                               for (var i=0;i<search.length;i++) {
                                       var prop = search[i].split("=");
                                       console.log(prop);
                                       if (prop[0] == "error") {
                                               if (prop[1] == "true") {
                                                       classAlert="alert-danger";
                                               } else {
                                                       classAlert="alert-success";
                                               }
                                       } else if (prop[0] == "msg") {
                                               message = decodeURIComponent(prop[1]);
                                       }
                               }
                               $(selector).removeClass("msg-erro-hide").addClass(classAlert).append(message);
                       }
               }
        },

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
	},
	obterUsuarios: function(callback) {
		this.sendAction({},"obter_usuarios", callback);
	},
	deletarUsuario: function(nome_usuario, callback) {
		this.sendAction({"nome_usuario": nome_usuario},"deletar_usuario", callback);
	},
	deletarVeiculo: function(modelo, ano_fabri, callback) {
		this.sendAction({"modelo": modelo,"ano_fabri": ano_fabri},"deletar_veiculo", callback);
	},
	deletarPessoa: function(cpf, callback) {
		this.sendAction({"cpf": cpf},"deletar_pessoa", callback);
	}
}
