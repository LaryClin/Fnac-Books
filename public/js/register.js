document.addEventListener("DOMContentLoaded", function() {

function e (tag, text, parent, classs=null, id=null, name=null) {

  let o = document.createElement(tag)
  if(text != null)
    o.appendChild(document.createTextNode(text))
  if(classs != null)
    o.classList.add(classs)
  if(id != null)
    o.id = id
  if(name != null)
    o.name = name
  parent.appendChild(o)
  return o
}


let checkBoxAdherent = document.querySelector("#adherent")

checkBoxAdherent.addEventListener("click", function(){
let div = document.querySelector("#test")
div.classList.toggle("numAdh")
})


checkBoxAdherent.addEventListener("click", function(){
divForm.remove()
labelNum.remove()
divInput.remove()
inputNum.remove()
console.log("HOP")
})
/*checkBoxAdherent.addEventListener("click", function(){
divForm.remove()
labelNum.remove()
divInput.remove()
inputNum.remove()
console.log(HOP)
})*/


})