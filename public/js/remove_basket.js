document.addEventListener("DOMContentLoaded", function() {

	/*-----Suppression des livres du panier-----*/
	let buttons = document.querySelectorAll(".del_livre");
	for (let b of buttons) {
		b.addEventListener('click', function(event) {

			let id = this.dataset.id;
			removeLivrePanier(id);

		});
	}

})
function removeLivrePanier(id) {
	let url = getURLPanier() + "/remove/" + id;
	console.log(url)
	fetch(url)
	.then(function(response) {
		console.log(response)
		return response
	}).then(function(data) {
		// console.log(data)
		let query = "[data-id='" + id + "']";
		let tds = document.querySelectorAll(query);
		for (let t of tds) {
			//console.log(t);
			removeNodePanier(t);
		}
	})
}

function removeNodePanier(elt) {
	elt.parentNode.removeChild(elt);
}

function getURLPanier() {
	let url = "/panier";
	return url;
}