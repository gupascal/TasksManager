// Ajoute les évènements liés aux boutons de delete des tasks
var aAddDeps = document.getElementsByTagName('a');	
for (var i = 0 ; i < aAddDeps.length ; i++)
{
	if (aAddDeps[i].classList.contains('addDeps')) {
		addEvent(aAddDeps[i], 'click', addDeps);
	}
}
alert("b");
function addDeps(e)
{
	var targ = getTarget(e);
	
	// Envoi un formulaire post vers le lien tms_tasks_manager_add_dep_form
	// Avec le parametre taskid
	// Appel la methode showFormAddDepths lors de la réponse
	// type de réponse : json
    /*s$.post('{{path('tms_tasks_manager_add_dep_form')}}',               
          {taskid: 'taskid'}, //> remplacer par l'id de la tache
          showFormAddDeps,
		  "json");   */ 
}

function showFormAddDeps(answer)
{
    if(answer.id != null && answer.deps != null)	//dummy check
	{
		//do something
    }
}

/*function confirmDelete(e)
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
    acceptLink.title = 'Delete Task';
	acceptLink.id = 'deleteTask';
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
}*/