document.addEventListener("DOMContentLoaded", function() {
	iniSuppression()
	iniModify()
})



function removeAllChildren(el)
{
	while(el.firstChild)
		el.removeChild(el.firstChild)
}

function iniModify()
{
	let libellesTD = document.querySelectorAll(".modify-genre")
	for(let libelleTD of libellesTD)
	{
		libelleTD.addEventListener("dblclick", function()
		{
			// Préparation
			removeAllChildren(this)
			let libelle = this.dataset.libelle

			// Création de l'input
			let input = e("input", libelleTD, "", null, "form-control")
			input.value = libelle
			input.dataset.id = this.dataset.id

			// Quand la valeur a changé
			input.addEventListener("change", function()
			{
				let idGen = this.dataset.id
				let url = "./genre/modify/"
				let token = getToken()
				let libelle = ucFirst(input.value.trim())

				// Envoi du formulaire
				fetch(url,
					{
						method: "POST",
			        	headers: {
					     "Content-Type": "application/json",
					     "Accept": "application/json, text-plain, */*",
					     "X-Requested-With": "XMLHttpRequest",
					     "X-CSRF-TOKEN": token
					    },
					    credentials: "same-origin",
					    body: JSON.stringify({
					    	id: idGen,
					    	libelle: libelle
					    })
			   		}
			    )
			    /*.then(function(response) {
			    	return response.json()
			    })
			    .then(function(data) {
			    	console.log(data)
			    })*/

			    // Restitution du paragraphe avec les changements
			    let text = e("p", input.parentNode, input.value)
			    this.parentNode.dataset.libelle = libelle
			    input.parentNode.removeChild(this)
			})
		})
	}
}

function iniSuppression()
{
	console.log("Suppression AJAX script")
	let supprimerBtns = document.querySelectorAll('.supprimer-genre-btn')
	for(let btn of supprimerBtns)
	{	
		btn.addEventListener("click", function()
		{
			// Remplissage des libelles
			prepareModal(this)

			// Gestion de la supression
			afficherModal(this)
		})
	}

	document.querySelector("#btn-modal-supression")
	.addEventListener("click", function() {
		formSuppression(this)
	})
}

function prepareModal(el)
{
	let libelle = el.dataset.libelle
	let spans = document.querySelectorAll("mark.modal-libelle")
	for(let span of spans)
	{
		removeAllChildren(span)
		span.appendChild(document.createTextNode(libelle))
	}
}

function afficherModal(el)
{
	let idGen = el.dataset.id
	let url = "./genre/check/" + idGen

	fetch(url).then(function($response) {
		return $response.json()
	}).then(function(data) {
		$('#erreur-supprimer-genre').modal()
		let pErreur = document.querySelector("#modal-error")
		let pConfirmation = document.querySelector("#modal-confirmation")
		let btnSupprimer = document.querySelector("#btn-modal-supression")

		if(data.genreStillUsed)
		{
			btnSupprimer.dataset.id = -1

			pErreur.classList.remove("hidden")
			pConfirmation.classList.add("hidden")
			btnSupprimer.classList.add("hidden")
		}
		else
		{
			btnSupprimer.dataset.id = idGen

			pErreur.classList.add("hidden")
			pConfirmation.classList.remove("hidden")
			btnSupprimer.classList.remove("hidden")
		}
	})
}

function formSuppression(el)
{
	let idGen = el.dataset.id
	let url = "./genre/delete/" + idGen
	let token = getToken()
	console.log(url)
	fetch(url,
		{
			method: "POST",
        	headers: {
		     "Content-Type": "application/json",
		     "Accept": "application/json, text-plain, */*",
		     "X-Requested-With": "XMLHttpRequest",
		     "X-CSRF-TOKEN": token
		    },
		    credentials: "same-origin",
		    body: JSON.stringify({name: "delete"})
   		}
    )
    .then(function($response) {
			console.log($response)
			return $response.json()
		}).then(function(data) {
			document.location.reload()
		})
}

function getToken()
{
	return document.querySelector('meta[name="csrf-token"]').getAttribute("content")
}

function e(tag, parent=null, text=null, id=null, classs=null)
{
	let o = null
	if(tag != null)
	{
		o = document.createElement(tag)
		if(text != null)
			o.appendChild(document.createTextNode(text))

		if(id != null)
			o.id = id

		if(classs != null)
			o.classList.add(classs)

		if(parent != null)
			parent.appendChild(o)
		else
			document.querySelector("body").appendChild(o)
	}
	return o
}

function ucFirst(str) {
  if (str.length > 0) {
    return str[0].toUpperCase() + str.substring(1);
  } else {
    return str;
  }
}