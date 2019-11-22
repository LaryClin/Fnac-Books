document.addEventListener("DOMContentLoaded", function() {

	// getting photos from dom
	let photos = document.querySelectorAll("img.img_delete");

	initDeleteModal();

	for (let p of photos) {
		p.addEventListener('click', function() {
			showDeleteModal(p);
		})
	}

});

function getPhotoURL() {
	return base_url + '/photos';
}

function initDeleteModal() {
	let btn_delete = document.querySelector("#btn-delete-img");

	btn_delete.addEventListener("click", function() {
		let id = btn_delete.dataset.id;
		if (id != "-1" && id != -1) {			
			deletePhoto(id);
		}
	});
}

function prepareDeleteModal(el) {
	let to_change = document.querySelector('#modal-img');
	let btn_delete = document.querySelector("#btn-delete-img");

	to_change.src = el.src;
	btn_delete.dataset.id = el.dataset.id;
}

function showDeleteModal(el)
{
	let id = el.dataset.id
	let url = getPhotoURL + "/delete/" + id;

	prepareDeleteModal(el);

	$('#modal-delete-img').modal()
}

function removeElt(elt) {
	elt.parentNode.removeChild(elt);
}

function removePhotoDOM(id) {
	let query = "div.img_col[data-id='" + id + "']";
	let col = document.querySelector(query);
	removeElt(col);
}

function deletePhoto(id) {

	let url = getPhotoURL() + "/delete/" + id;
	console.log(url);
	let token = getToken();

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
		return $response.json()
	}).then(function(data) {
		console.log(data);
		removePhotoDOM(id);
	});

}

function getToken() {
	return document.querySelector('meta[name="csrf-token"]').getAttribute("content")
}

