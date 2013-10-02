(function(global){
	var API = function(){
		var self = this;
		
		self.path = '/api/';
		self.dataType = 'json';	
	};
	API.prototype = {
		request: function(method, params, callback){
			var self = this;
			if(self.dataType == 'json'){
				if(ID && ID.areFeatures('jsonGet', 'parseJson')){
					if(params){
						ID.ajaxPost(self.path + method, {
							params: params,
							success: function(data){
								var parsedJson = {};
								if(data){
									parsedJson = ID.parseJson(data);
								}
								if(callback){
									callback(data);
								}
							}
						});
					}else{
						ID.jsonGet(self.path + method, {
							success: callback
						});
					}
				}
			}
		}
	}
	global.API = API;
})(window);