document.addEventListener("DOMContentLoaded", function() {
	iniModify()
})



function removeAllChildren(el)
{
	while(el.firstChild)
		el.removeChild(el.firstChild)
}

function iniModify()
{
	let champs = document.querySelectorAll(".modify")
	for(let champ of champs)
	{
		champ.addEventListener("dblclick", function()
		{

			// Préparation
			removeAllChildren(this)
			let nomChamp = this.dataset.value
			let typeChamp = this.dataset.champ
			let nomChampError = this.dataset.nom
			// Création de l'input
			let input
			if(typeChamp == "adh_motpasseold" || typeChamp == "adh_motpasse"){
				input = e("input", champ, "", null, "form-control", "password")
			}

			else{
				input = e("input", champ, "", null, "form-control")
			}

				input.value = nomChamp
				input.dataset.id = this.dataset.id
				input.dataset.champ = typeChamp
				input.dataset.nomChamp = nomChamp
				input.dataset.nom = nomChampError

		


			// Quand la valeur a changé
			input.addEventListener("change", function()
			{
				let adh_id = this.dataset.id
				let url = "./modify"
				let token = getToken()
				let newNomChamp = input.value.trim()
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
					    	adh_id: adh_id,
					    	champ: newNomChamp,
					    	typeChamp: this.dataset.champ,
					    	nomChampError: this.dataset.nom,

					    })
			   		}
			    )
			    .then(function(response) {
			    	console.log(response)
			    	return response.json()
			    })
			    .then(function(data) {
			    	// console.log(data)
			    	// console.log(typeChamp)
			    	//On récupère le nom de l'erreur pour pouvoir l'affecter au bon input
			    	let champError = data["error"][0]
			    	//On récupère le libelle "nom, prenom, mail etc" pour le message d'erreur
			    	let nomChampError = data["nomChampError"] 
			    	//On ajoute le message d'erreur
			    	if(champError){
			    		// Restitution du paragraphe avec l'ancienne valeur
			    		let text = e("p", input.parentNode, nomChamp)
			    		champ.parentNode.dataset.value = nomChamp
			    		input.parentNode.removeChild(input)
			    		let error = e("span", champ, "Le format du "+nomChampError+" n'est pas valide", null, "help-box2")
			    	}
			    	else{

			    		if(typeChamp == "adh_motpasseold" && data["motpasse"] == true){
			    			let champMotPasse = document.querySelector(".mdp")
			   				champMotPasse.classList.remove("mdp")
			   				let text = e("p", input.parentNode, "*********")
			    			champ.parentNode.dataset.value = newNomChamp
			    			input.parentNode.removeChild(input)
			    		}
			    		else if(typeChamp == "adh_motpasseold" && data["motpasse"] == false){
			    			let text = e("p", input.parentNode, "**********")
			    			champ.parentNode.dataset.value = newNomChamp
			    			input.parentNode.removeChild(input)
			    			let error = e("span", champ, "Votre " +nomChampError+ " est incorrect !", null, "help-box2")
			    		}
			    		else{
			    		// Restitution du paragraphe avec les changements
			    			let text = e("p", input.parentNode, newNomChamp)
			    			champ.parentNode.dataset.value = newNomChamp
			    			input.parentNode.removeChild(input)
			    			let error = e("span", champ, "Votre " +nomChampError+ " a été modifié avec succès !", null, "help-box-success")
			    			if(typeChamp == "adh_motpasse")
			    				document.location.reload(true);
			    		}

			    	}
			    })
			})
		})
	}
}



function getToken()
{
	return document.querySelector('meta[name="csrf-token"]').getAttribute("content")
}

function e(tag, parent=null, text=null, id=null, classs=null, type=null)
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

		if(type != null)
			o.type = type

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