var converter = new Showdown.converter();

$(document).ready(function(){
	
	var h1 = document.getElementById('body-nav').offsetHeight;
	var h2 = document.getElementById('body-article').offsetHeight;
	if(h1 > h2){
		$('#body-content').css('height',h1+'px');
	}
	else{
		$('#body-content').css('height',h2+'px');
	}
	
});
