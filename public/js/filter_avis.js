document.addEventListener('DOMContentLoaded', function(){

	console.log("test");
	let nosort = document.querySelector("#nosort_button");
	let sort_date = document.querySelector("#sort_by_date_button");
	let sort_date_note = document.querySelector("#sort_by_noteanddate_button");

	// ces urls ne marchent que si le serveur est up (pas avec le /~fnac2c/public_html/...)

	nosort.addEventListener("click", function(){
		// removeAvis();
		getAvis("/avis/tous/" + this.dataset.id);
	});

	sort_date.addEventListener("click", function(){
		getAvis("/avis/date/" + this.dataset.id);
	});

	sort_date_note.addEventListener("click", function(){
		getAvis("/avis/date_et_note/" + this.dataset.id);
	})

});

function removeAvis() {
	let div = document.querySelector("#all_avis");
	div.innerHTML = [];
	console.log("Deleted!");
}

function getAvis(url) {
	fetch(url)
    	.then(function($response) {
			//console.log($response)
			return $response.json()
		}).then(function(data) {
			//document.location.reload()
			//console.log(data);
			removeAvis();
			for (let a of data['avis']) {
				//console.log(a);
				createOneAvis(a);
			}
		})
}

function createOneAvis(data) {
	let avis_parent = document.querySelector("#all_avis");
	let mon_avis = e("div", "", avis_parent, "avis");
	let titre = e("h3", data['avi_titre'], mon_avis);
	let note = e("p", data['avi_note'] + "/5", mon_avis);
	let details = e("p", data['avi_detail'], mon_avis);
	let avis_date = e("p", data['avi_date'], mon_avis);
	let adherent = e("p", data['adh_pseudo'], mon_avis);

	// TODO !!!
}

function getToken()
{
	return document.querySelector('meta[name="csrf-token"]').getAttribute("content")
}

function e(tag, text, parent, classs=null, id=null) {
	let o = document.createElement(tag)
	o.appendChild(document.createTextNode(text))
	o.id = id
	o.classList.add(classs)
	parent.appendChild(o)
	return o
}