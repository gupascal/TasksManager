function confirmDelete(e)
{
	e.preventDefault();	// On bloque l'action par défaut de cet élément
	
	var targ;
	if (!e) var e = window.event;
	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;
	if (targ.nodeType == 3) // defeat Safari bug
		targ = targ.parentNode;
	// targ contient le lien de suppression de la tache
	
	// Div principale du message à afficher
	var divPopUp = document.createElement('div');
	divPopUp.id = 'deletePopUp';
	
	// Chaines de textes
	var textNodes = [
		document.createTextNode('Confirm you want to delete this Task ?'),
		document.createTextNode('Yes'),
		document.createTextNode('No')
	];
	
	var message = document.createElement('p');
	message.appendChild(textNodes[0]);
	
	var choice = document.createElement('p');
	
	var acceptLink = document.createElement('a');
    acceptLink.href  = targ;
    acceptLink.title = 'delete_task';
	acceptLink.appendChild(textNodes[1]);
	choice.appendChild(acceptLink);
	
	var refuseLink = document.createElement('a');
    refuseLink.href  = '#';
    refuseLink.title = 'keep_task';
	refuseLink.appendChild(textNodes[2]);
	choice.appendChild(refuseLink);
	
	divPopUp.appendChild(message);
	divPopUp.appendChild(choice);
	
	document.body.appendChild(divPopUp);
}
			
function addEvent(elem, event, action)
{
	if (elem.addEventListener)
		elem.addEventListener(event, action, false);
	else
		elem.attachEvent('on'.event, action);
}
			
// Ajoute les évènements liés aux boutons de delete des tasks
var aTags = document.getElementsByTagName('a');	
for (var i = 0 ; i < aTags.length ; i++)
{
	if (aTags[i].classList.contains('deleteBtn')) {
		addEvent(aTags[i], 'click', confirmDelete);
	}
}