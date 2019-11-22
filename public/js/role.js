document.addEventListener('DOMContentLoaded', function() {

	// get dom elements
	let buttons = document.querySelectorAll('.save_role_btn');
	let selects = document.querySelectorAll('.role_select');

	for (let b of buttons) {
		b.addEventListener('click', function() {

			let adh_id = this.dataset.adh_id;
			let select = document.querySelector("select[data-adh_id='" + adh_id + "']");
			let rol_id = select.options[select.selectedIndex].value;

			modifyRole(this, adh_id, rol_id);
		})
	}

	for (let s of selects) {
		s.addEventListener('change', function() {

			let adh_id = this.dataset.adh_id;
			let query = ".save_role_btn[data-adh_id='" + adh_id + "']";

			let btn = document.querySelector(query);
			btn.classList.replace('btn-default', 'btn-primary');

		})
	}

});

function modifyRole(button, adh_id, rol_id) {

	let url = getRoleURL() + "/moderate/update/" + adh_id + "/" + rol_id;
	let token = getRoleToken();

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
		button.classList.replace('btn-primary', 'btn-default');
		//console.log(data);
	});

}

function getRoleURL() {
	let url = base_url + '/admin';
	return url;
}

function getRoleToken() {
	return document.querySelector('meta[name="csrf-token"]').getAttribute("content")
}
