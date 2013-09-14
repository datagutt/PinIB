(function(global){
	var Site = global.Site || {};
	if(Site.addToQueue){
		Site.addToQueue(function threadsList(){
			var threads = new Masonry('#threads', {
				columnWidth: 180,
				gutter: 10,
				itemSelector: '.post'
			});
		});
	}
	global.Site = Site;
})(window);