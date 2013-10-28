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
									callback(null, data);
								}
							},
							fail: function(err){
								callback(err, false);
							}
						});
					}else{
						ID.jsonGet(self.path + method, {
							success: function(data){
								callback(null, data);
							},
							fail: function(err){
								callback(err, false);
							}
						});
					}
				}
			}
		}
	}
	global.API = API;
})(window);