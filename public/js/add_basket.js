document.addEventListener("DOMContentLoaded", function() {
	let buttonAdd = document.querySelector(".add_panier_button")
	let parentDiv = document.querySelector(".add_basket")
	var verif = 0;
	let url
	buttonAdd.addEventListener("click",function(){
		let id = this.dataset.id;
		let stock = this.dataset.stock;
		/*---Création du label---*/
		label = create("label","Indiquez le nombre d'articles : ", parentDiv, "label")
		label.classList.add("label-info")

		/*---Création de l'input---*/
		chooseNb = create("input","",parentDiv,"form-control")
		chooseNb.setAttribute("type","number")
		chooseNb.setAttribute("min",0)
		chooseNb.setAttribute("max",stock)


		/*---Suppression du button d'avant---*/
		buttonAdd.style.display = "none"

		/*---Création du nouveau bouton---*/
		newButtonAdd = create("button","Ajouter",parentDiv,"btn")
		newButtonAdd.classList.add("newButtonAdd")
		newButtonAdd.classList.add("btn-primary")

		/*---Gère l'ajout---*/
		newButtonAdd.addEventListener("click",function(){

			let qte = chooseNb.value
			if(parseInt(qte, 10) > 0 && parseInt(qte,10)<=parseInt(stock,10)){
				addToPanier(id, qte);
				/*
				url = getPanierURL() + "/addPanier?id=" + id + "&qte=" + qte;
				if (url != null) {
					sendPanierRequest(url);
					removeAddPanierMessages();
					message_succes = create("p","Livre(s) ajouté au panier",parentDiv,"text-success message_add_panier")
				}
				else
				{
					removeErrorPanierMessages();
					message_error_title = create("h3","Il y a eu un problème !", parentDiv,"text-danger message_error_panier")
					message_error_text = create("p","Veuillez vérifier si vous ne dépassez pas le stock",parentDiv,"text-danger message_error_panier")
					verif = 0
				}
				*/
			}
			else{
				removeErrorPanierMessages();
				removeAddPanierMessages();
				let txt_error = "";
				if (parseInt(qte, 10) <= 0) {
					txt_error = "Saisie invalide";
				} else {
					txt_error = "Stock insufisant";
				}
				message_error_text = create("p",txt_error,parentDiv,"text-danger message_error_panier")
				verif=0
			}
		})
	})

	
})

/*-----Créer de nouveaux éléments-----*/
function create(tag, text, parent, classs=null, id=null){
	let o = document.createElement(tag)
	if(text != null)
		o.appendChild(document.createTextNode(text))
	if(classs!=null)
		o.classList = classs 
	if(id!=null)
		o.id = id
	parent.appendChild(o)
	return o
}

function removeAddPanierMessages() {
	let messages = document.querySelectorAll('.message_add_panier');
	for (let m of messages) {
		deleteElement(m);
	}
}

function removeErrorPanierMessages() {
	let messages = document.querySelectorAll('.message_error_panier');
	for (let m of messages) {
		deleteElement(m);
	}
}

function sendPanierRequest(url) {
	console.log(url);
	fetch(url)
	.then(function(response) {
		//console.log(response)
		return response.json();
	}).then(function(data) {
		console.log(data)
	})
}

function addToPanier(liv_id, to_add_qte) {
	let url = getPanierURL() + "/addPanier?id=" + liv_id + "&qte=" + to_add_qte;
	let parentDiv = document.querySelector(".add_basket")
	
	fetch(url)
	.then(function(response) {
		//console.log(response)
		return response.json();
	}).then(function(data) {
		// console.log(data)
		removeAddPanierMessages();
		removeErrorPanierMessages();
		if (data['added']) {
			message_succes = create("p","Livre(s) ajouté au panier",parentDiv,"text-success message_add_panier")
		} else {
			message_error_text = create("p","Stock insufisant",parentDiv,"text-danger message_error_panier")
		}
	})
}

function deleteElement(elt) {
	elt.parentNode.removeChild(elt);
}

function getPanierURL() {
	let url = base_url + "/panier";
	return url;
}
