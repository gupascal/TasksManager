// Ajoute les évènements liés aux boutons de delete des tasks
var aAddDeps = document.getElementsByTagName('a');	
for (var i = 0 ; i < aAddDeps.length ; i++)
{
	if (aAddDeps[i].classList.contains('addDeps')) {
		addEvent(aAddDeps[i], 'click', addDeps);
	}
}

function addDeps(e)
{
	var targ = getTarget(e);
	
	// Envoi un formulaire post vers le lien tms_tasks_manager_add_dep_form
	// Avec le parametre taskid
	// Appel la methode showFormAddDepths lors de la réponse
	// type de réponse : json
	$.post(addDepsFormAction,               
		  { taskid: targ.id },
		  showFormAddDeps,
		  "json");
}

function showFormAddDeps(answer)
{
	if (answer.taskid == null && answer.deps == null)
		return;
		
	// Div principale du message à afficher
	var divPopUp = document.createElement('div');
	divPopUp.id = 'addDepsForm';
	
	// Chaines de textes
	var textNodes = [
		document.createTextNode('Choose task dependences :'),
		document.createTextNode('Cancel')
	];
	
	// Paragraphe d'introduction
	var message = document.createElement('p');
	message.appendChild(textNodes[0]);
	
	
	// Formulaire de choix des dépendances
	var form = document.createElement('form');
	form.action  = addDepsAction;
	form.enctype = 'multipart/form-data';
	form.method  = 'post';
	
	var selectTasks = document.createElement('select');
	selectTasks.multiple = "multiple";
	
	// Boucle pour afficher toutes les taches possibles
	for (var i = 0 ; i < answer.deps.length ; i++)
	{
		// Déserialize le tableau reçu
		var task_deserialise = JSON.parse(answer.deps[i]);
		
		// Cré une option au select
		var optionTask = document.createElement('option');
		optionTask.value = task_deserialise.name;
		optionTask.appendChild( document.createTextNode( task_deserialise.name ) );
		
		// Ajoute l'option au select
		selectTasks.appendChild(optionTask);
	}
	
	form.appendChild(selectTasks);
	
	var submit = document.createElement('input');
	submit.type  = 'submit';
	submit.value = 'Add';
	form.appendChild(submit);
	
	// Paragraphe final
	var cancel = document.createElement('p');
	
	var refuseLink = document.createElement('a');
	refuseLink.href  = '#';
	refuseLink.onclick = destroyPopUpAddDepsTask;
	refuseLink.id = 'cancel';
	refuseLink.appendChild(textNodes[1]);
	
	cancel.appendChild(refuseLink);
	
	// Ajout de tous les paragraphes
	divPopUp.appendChild(message);
	divPopUp.appendChild(form);
	divPopUp.appendChild(cancel);
	
	// Ajout au body
	document.body.appendChild(divPopUp);
}

function destroyPopUpAddDepsTask()
{
	var body = document.body
	var popUp = document.getElementById("addDepsForm");

	body.removeChild(popUp);
}