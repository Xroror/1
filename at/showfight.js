function loadpageJS(){
	document.getElementById('fselect').addEventListener('change', getdetails);
	
}

function getdetails(e){
	var fDetails = document.getElementsByClassName('showdetails');
	for(var i = 0;i<fDetails.length;i++){
		fDetails[i].className = 'hidedetails';
	}
	document.getElementById(e.target.selectedOptions[0].text).className = 'showdetails';
}