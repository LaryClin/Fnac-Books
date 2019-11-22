document.addEventListener("DOMContentLoaded", function() {

	let buttons = document.querySelectorAll(".del_livre");
	for (let b of buttons) {
		b.addEventListener('click', function(event) {

			let id = this.dataset.id;
			removeLivre(id);

		});
	}

});

function removeLivre(id) {
	let url = getURL() + "/remove/" + id;

	fetch(url)
	.then(function(response) {
		// console.log(response)
		return response
	}).then(function(data) {
		// console.log(data)
		let query = "[data-id='" + id + "']";
		let tds = document.querySelectorAll(query);
		for (let t of tds) {
			//console.log(t);
			removeNode(t);
		}
	})
}

function removeNode(elt) {
	elt.parentNode.removeChild(elt);
}

function getURL() {
	let url = base_url + "/comparateur";
	return url;
}
