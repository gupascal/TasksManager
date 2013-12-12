// Ajoute les évènements liés aux boutons de delete des tasks
var aDeleteTask = document.getElementsByTagName('a');	
for (var i = 0 ; i < aDeleteTask.length ; i++)
{
	if (aDeleteTask[i].classList.contains('deleteBtn')) {
		addEvent(aDeleteTask[i], 'click', confirmDelete);
	}
}

function confirmDelete(e)
{
	e.preventDefault();	// On bloque l'action par défaut de cet élément
	var targ = getTarget(e);
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
	
	var idTask = String(targ.id).split("_", 2);
	
	var acceptLink = document.createElement('a');
    acceptLink.href  = '#';
	acceptLink.onclick = deleteTaskFromPage;
    acceptLink.title = 'Delete Task';
	acceptLink.className += ' deleteTaskLink';
	acceptLink.id = 'deleteTask_' + idTask[1];
	acceptLink.appendChild(textNodes[1]);
	choice.appendChild(acceptLink);
	
	var refuseLink = document.createElement('a');
    refuseLink.href  = '#';
	refuseLink.onclick = destroyPopUpDeleteThisTask;
    refuseLink.title = 'Keep Task';
	refuseLink.id = 'keepTask';
	refuseLink.appendChild(textNodes[2]);
	choice.appendChild(refuseLink);
	
	divPopUp.appendChild(message);
	divPopUp.appendChild(choice);
	
	document.body.appendChild(divPopUp);
}

function destroyPopUpDeleteThisTask()
{
	var body = document.body
	var popUp = document.getElementById("deletePopUp");

	body.removeChild(popUp);
}

function deleteTaskFromPage(e)
{
	e.preventDefault();
	var targ = getTarget(e);
	// Id tâche à supprimer sur la page
	var idTask = String(targ.id).split("_", 2);
	
	// URL pour supprimer la tâche récupérer grâce au lien de suppression de tâche
	var urlDelete = document.getElementById('delete_' + idTask[1]);
	
	// Envoi la requête get pour supprimer la tâche
	$.get(urlDelete.href,               
		  { },
		  null,
		  "json");

	// Supprime la div de la tâche
	$('#task_' + idTask[1]).remove();
	// Détruit la Popup
	destroyPopUpDeleteThisTask();
}