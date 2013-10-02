(function(global){
	var API = global.API;
	var ThreadAPI = function(){
		var self = this;
		
		self.path = '/api/';
		self.dataType = 'json';	
	};
	
	ThreadAPI.prototype = {
		getThreads: function(callback){
			var self = this;
			
			self.request('threads', false, callback);
		}
	}
	
	if(ID && ID.areFeatures('mixin')){
		ID.mixin(ThreadAPI.prototype, API.prototype);
	}
	
	global.ThreadAPI = ThreadAPI;
})(window);