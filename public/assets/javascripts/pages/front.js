(function(global){
	var Site = global.Site || {}
	if(Site.addToQueue){
		Site.addToQueue(function threadsList(){
			var threads = new Masonry('#threads', {
				columnWidth: 210,
				gutter: 10,
				itemSelector: '.thread'
			}), api = new ThreadAPI;
			
			api.getThreads(function getThreads(err, data){
				if(err){
					
				}
				console.log(data);
				
				setTimeout(getThreads, 10000);
			});
		});
	}
	global.Site = Site;
})(window);