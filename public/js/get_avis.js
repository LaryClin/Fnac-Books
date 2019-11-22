document.addEventListener("DOMContentLoaded", function(){

	console.log("Authed : " + authed)
	// console.log("Adh_id : " + adh_id)

	let query = {
		"avi_date": "",
		"avi_note": "",
		"liv_id" : livid
	}

	let activ = document.querySelector('li.active');
	let page = 1;

	let sorts = document.querySelectorAll(".sorting");
	for (let s of sorts) {
		s.addEventListener('change', function() {
			let val = s.value;
			let col = s.dataset.col_name;
			if (val != null) {
				query[col] = val;
				//console.log("key: " + col)
				//console.log("val: " + val)
				let q = getAvisURL() + "?page=" + page + "&" + concatQuery(query);
				getData(q);
			}
			
		})
	}

	let links = document.querySelectorAll(".pagination a");
	for (let l of links) {
		//l.style.backgroundColor = "red";
		l.addEventListener("click", function(event) {
			event.preventDefault();
			if (!l.parentNode.classList.contains("active")) {
				let q = getAvisURL() + "?page=" + l.innerHTML + "&" + concatQuery(query);
				page = l.innerHTML;
				console.log(l.innerHTML)
				console.log(q)
				getData(q);
				setInactive(activ);
				setActive(l);
				activ = l;
			}
			
			//console.log(l.innerHTML)
			//console.log(q)

		})
	}

	//console.log(getPage())
	function setInactive(elt) {
		let act = document.querySelector('li.active');
		act.classList.remove("active")
		let val = act.children[0];
		act.innerHTML = "";
		let a = e("a", val.innerHTML, act);
		a.addEventListener("click", function(event) {
			event.preventDefault();
			if (!a.parentNode.classList.contains("active")) {
				let q = getAvisURL() + "?page=" + a.innerHTML + "&" + concatQuery(query);
				page = a.innerHTML;
				getData(q);
				setInactive(activ);
				setActive(a);
				activ = a;
			}
			
			//console.log(l.innerHTML)
			//console.log(q)

		})
	}

});

function concatQuery(query) {
	let final = "";
	let i = 0;
	for (let k in query) {
		final = final + k + "=" + query[k];
		i++;
		if (i < 2) { // not last elt
			final += "&";
		}
	}
	return final;
}

function getData(url) {
	fetch(url)
	.then(function(response) {
		console.log(response)
		return response.json()
	}).then(function(data) {
		//document.location.reload()
		//console.log(data)
		clearTable();
		for (let elt of data.avis.data) {
			createOneAvis(elt);
		}
	})
}

function e(tag, text, parent, classs=null, id=null) {
	let o = document.createElement(tag)
	o.appendChild(document.createTextNode(text))
	
	if(id != null)
		o.id = id
	
	if(classs != null && classs.trim() != "")
		for(let classx of classs.split(' '))
			o.classList.add(classx)
	
	parent.appendChild(o)
	return o
}

function createOneAvis(data) {
	console.log(data)
	let tbody = document.querySelector("tbody");
	let tr = e("tr", "", tbody)
	let titre = e("td", data.avi_titre, tr)
	let note = e("td", data.avi_note, tr)
	let description = e("td", data.avi_detail, tr)
	let date = e("td", data.avi_date, tr)
	let adherent = e("td", data.adh_pseudo, tr)
	if(authed)
	{
		let utiletd = e("td", "", tr)
		let btngroupediv = e("div", "", utiletd)
		btngroupediv.classList.add('btn-group')
		if(!data.myAvisUtileExist)
		{
			let autile = e("a", "oui("+data.avi_nbutileoui+")", btngroupediv)
			let apasutile = e("a", "non("+data.avi_nbutilenon+")", btngroupediv)
			
			autile.href = "/avis/utile/add?avi_id=" + data.avi_id + "&adh_id="+ auth_id + "&utile=1";
			apasutile.href = "/avis/utile/add?avi_id=" + data.avi_id + "&adh_id="+ auth_id + "&utile=0";

			autile.classList.add("btn")
			apasutile.classList.add("btn")

			autile.classList.add("btn-default")
			apasutile.classList.add("btn-default")
		}
		else
		{
			if(data.myAvisUtile != 'undefined')
			{
				if(data.myAvisUtile.avu_utile)
				{
					let autile = e("a", "oui("+data.avi_nbutileoui+")", btngroupediv)
					let apasutile = e("a", "non("+data.avi_nbutilenon+")", btngroupediv)
					
					autile.href = "/avis/utile/add?avi_id=" + data.avi_id + "&adh_id="+ auth_id + "&utile=1";
					apasutile.href = "/avis/utile/add?avi_id=" + data.avi_id + "&adh_id="+ auth_id + "&utile=0";

					autile.classList.add("btn")
					apasutile.classList.add("btn")

					autile.classList.add("btn-success")
					apasutile.classList.add("btn-default")
				}
				else
				{
					let autile = e("a", "oui("+data.avi_nbutileoui+")", btngroupediv)
					let apasutile = e("a", "non("+data.avi_nbutilenon+")", btngroupediv)
					
					autile.href = "/avis/utile/add?avi_id=" + data.avi_id + "&adh_id="+ auth_id + "&utile=1";
					apasutile.href = "/avis/utile/add?avi_id=" + data.avi_id + "&adh_id="+ auth_id + "&utile=0";

					autile.classList.add("btn")
					apasutile.classList.add("btn")

					autile.classList.add("btn-default")
					apasutile.classList.add("btn-danger")
				}
			}
		}
	}

	if(authed)
	{
		let signalerTd = e("td", "", tr)
		let signalerBtn = e("a", "Signaler", signalerTd, "btn btn-default")
		if(data.alreadySignaled)
		{
			signalerBtn.href = ""
			signalerBtn.classList.add("disabled")
		}
		else
		{
			signalerBtn.href = "/avis/signaler/" +data.avi_id
		}
	}

}

function getAvisURL() {
	let url;
	let tab = window.location.href.split('/');
	let id = tab[tab.length-1].split('?')[0];

	if (typeof base_url == "undefined") {
		url = window.location.origin 
			? window.location.origin + '/'
			: window.location.protocol + '/' + window.location.host + '/';
		url += "avis/fetch_data/" + id;
	} else {
		url = base_url + "/avis/fetch_data/" + id;
	}
	
	return url;
}

/*
function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}
*/

function clearTable() {
	let tbody = document.querySelector("tbody");
	tbody.innerHTML = "";
}

function setActive(elt) {
	elt.parentNode.classList.add("active");
}
