document.addEventListener("DOMContentLoaded", function() {

	// CHANGE QTE
	let inputs = document.querySelectorAll(".item_number_input");
	for (let i of inputs) {
		i.addEventListener('change', function() {
			modifyQte(this);
		});
	}

	// DELETE ITEM
	let buttons = document.querySelectorAll("button.delete_item_panier");
	for (let b of buttons) {
		b.addEventListener('click', function(){
			removeItem(this);
		});
	}

});

function removeItem(elt) {
	let liv_id = elt.dataset.liv_id;
	let url = getPanierURL() + "/remove/" + liv_id;
	let token = getPanierToken();

	fetch(url, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"Accept": "application/json, text-plain, */*",
			"X-Requested-With": "XMLHttpRequest",
			"X-CSRF-TOKEN": token
		},
		credentials: "same-origin"
	}).then(function($response) {
		console.log($response);
		return $response.json()
	}).then(function(data) {
		deleteLine(liv_id);
		calculateTotalPrice();
	});
}

function deleteLine(id) {
	let tr = document.querySelector("tr.panier_item[data-liv_id='" + id + "']");
	removeElt(tr);
}

function modifyQte(elt) {

	let liv_id = elt.dataset.liv_id;
	let new_qte = elt.value;

	let url = getPanierURL() + "/modifyQte/" + liv_id + "/" + new_qte;
	let token = getPanierToken();

	fetch(url, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"Accept": "application/json, text-plain, */*",
			"X-Requested-With": "XMLHttpRequest",
			"X-CSRF-TOKEN": token
		},
		credentials: "same-origin"
	}).then(function($response) {
		//console.log($response);
		return $response.json()
	}).then(function(data) {
		if (data['modified']) {
			elt.dataset.previous = new_qte;
			calculatePrice(elt);
			calculateTotalPrice();
		} else {
			elt.value=elt.dataset.previous;
		}
	});
}

function calculatePrice(elt) {
	let qte = parseFloat((document.querySelector(".item_number_input[data-liv_id='" + elt.dataset.liv_id + "']")).value);
	let prix_u = parseFloat((document.querySelector("span.liv_prix_unitaire[data-liv_id='" + elt.dataset.liv_id + "']")).innerHTML);

	let price = document.querySelector("span.liv_prix_total[data-liv_id='" + elt.dataset.liv_id + "']");
	price.innerHTML = (qte * prix_u).toFixed(2);
}

function calculateTotalPrice() {
	let total_elt = document.querySelector('#total_price');
	let prices = document.querySelectorAll('.liv_prix_total');

	let total = 0;
	for (let p of prices) {
		total += parseFloat(p.innerHTML);
	}

	total_elt.innerHTML = total.toFixed(2);
}

function getPanierURL() {
	return base_url + "/panier";
}

function getPanierToken() {
	return document.querySelector('meta[name="csrf-token"]').getAttribute("content");
}

function removeElt(elt) {
	elt.parentNode.removeChild(elt);
}