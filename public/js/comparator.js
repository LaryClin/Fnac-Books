document.addEventListener("DOMContentLoaded", function() {

	let comparator_buttons = document.querySelectorAll(".comparator_button");
	console.log(comparator_buttons);
	for (let b of comparator_buttons) {
		b.addEventListener("click", function(event){

			let inComparator = this.dataset.comparator;
			let id = this.dataset.id;

			if (inComparator == "not_in") {
				addToComparator(id, this);
			} else if (inComparator == "in") {
				removeFromComparator(id, this);
			}

		});
	}
});

function addToComparator(id, elt) {
	let url = getComparatorURL() + "/add/" + id;
	fetch(url)
	.then(function(response) {
		//console.log(response)
		return response.json();
	}).then(function(data) {
		// console.log(data)

		if (data["full"]) {
			$('#erreur-comparateur-complet').modal()

			let pErreur = document.querySelector("#modal-error")
			let pConfirmation = document.querySelector("#modal-confirmation")
			let btnSupprimer = document.querySelector("#btn-modal-supression")


		} else {
			elt.dataset.comparator = "in";
			elt.classList.remove("btn-success");
			elt.classList.add("btn-danger");
			elt.innerHTML = "Supprimer du comparateur";
		}

	})
}

function removeFromComparator(id, elt) {
	let url = getComparatorURL() + "/remove/" + id;
	fetch(url)
	.then(function(response) {
		console.log(response)
		return response;
	}).then(function(data) {
		//console.log(data)
		elt.dataset.comparator = "not_in";
		elt.classList.remove("btn-danger");
		elt.classList.add("btn-success");
		elt.innerHTML = "Ajouter au comparateur";
	})
}

function getComparatorURL() {
	let url = base_url + "/comparateur";
	return url;
}