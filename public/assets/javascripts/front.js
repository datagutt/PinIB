(function(global){
	var Site = global.Site || {};
	if(Site.addToQueue){
		Site.addToQueue(function threadsList(){
			var threads = new Masonry('#threads', {
				columnWidth: 210,
				gutter: 10,
				itemSelector: '.thread'
			});
		});
	}
	global.Site = Site;
})(window);