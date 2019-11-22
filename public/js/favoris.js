document.addEventListener("DOMContentLoaded", function(){

	//console.log("test");

	/* FAVORITE TABLE */
	let delete_buttons = document.querySelectorAll(".fav_delete_button");

	for (let b of delete_buttons) {
		b.addEventListener("click", function(){

			let b_id = this.dataset.id;
			deleteFavoriInTable(b_id);

		});
	}

	/* FAVORITE BUTTON ON BOOK PAGE */
	let fav_buttons = document.querySelectorAll(".favorite_button");
	for (let b of fav_buttons) {
		b.addEventListener("click", function(){

			let b_id = this.dataset.id;
			let state = this.dataset.favorite;

			if (state == "in") {
				removeFromFavorite(b_id, this);
			} else if (state == "not_in") {
				addToFavorite(b_id, this);
			}

		});
	}

});

function removeFromFavorite(id, elt) {
	let url = getFavorisURL() + "/remove/" + id;
	fetch(url)
	.then(function(response) {
		//console.log(response)
		return response
	}).then(function(data) {
		// console.log(data)
		elt.dataset.favorite = "in";
		elt.classList.remove("btn-danger");
		elt.classList.add("btn-success");
		elt.innerHTML = "Ajouter aux favoris";

	})
}

function addToFavorite(id, elt) {
	let url = getFavorisURL() + "/add/" + id;
	fetch(url)
	.then(function(response) {
		//console.log(response)
		return response
	}).then(function(data) {
		// console.log(data)
		elt.dataset.favorite = "not_in";
		elt.classList.remove("btn-sucess");
		elt.classList.add("btn-danger");
		elt.innerHTML = "Supprimer des favoris";

	})
}

function deleteFavoriInTable(id) {
	let url = getFavorisURL() + "/remove/" + id;

	fetch(url)
	.then(function(response) {
		console.log(response)
		return response
	}).then(function(data) {
		// console.log(data)
		let query = "tr[data-id='" + id + "']";
		let tr = document.querySelector(query);
		remove(tr);
	})
}

function remove(elt) {
	elt.parentNode.removeChild(elt);
}

function getFavorisURL() {
	return base_url + "/favoris";
}