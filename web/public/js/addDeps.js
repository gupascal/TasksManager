// Ajoute les évènements liés aux boutons d'ajout de dépendances entre tâches
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
	form.action  = '';
	form.enctype = 'multipart/form-data';
	form.method  = 'post';
	form.onsubmit = addTasksToDB;
	
	var selectTasks = document.createElement('select');
	selectTasks.multiple = "multiple";
	
	// Boucle pour afficher toutes les taches possibles
	for (var i = 0 ; i < answer.deps.length ; i++)
	{
		// Déserialize le tableau reçu
		var task_deserialise = JSON.parse(answer.deps[i]);
		
		// Cré une option au select
		var optionTask = document.createElement('option');
		optionTask.value = task_deserialise.id;
		optionTask.appendChild( document.createTextNode( task_deserialise.name ) );
		
		// Ajoute l'option au select
		selectTasks.appendChild(optionTask);
	}
	
	form.appendChild(selectTasks);
	
	// Champs caché contenant l'id de la task à laquelle on veut ajouter des dépendances
	var idTaskAsker = document.createElement('input');
	idTaskAsker.type  = 'hidden';
	idTaskAsker.id  = 'taskAsker';
	idTaskAsker.appendChild( document.createTextNode( answer.taskid ) );
	form.appendChild(idTaskAsker);
	
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

function addTasksToDB(e)
{
	// Récupère l'id de la tache à laquelle on ajoute des dépendances
   var idTask = document.getElementById('taskAsker');
   // Récupère les options du formulaire d'ajout de dépendance
   var tasks = document.getElementsByTagName('option');
   
   // Initialise arrayTask avec les taches dépendantes sélectionnées
   var arrayTask = new Array();
   for (var i = 0 ; i < tasks.length ; i++)
   {
		if (tasks[i].selected)
			arrayTask.push(tasks[i].value);
   }
   
   // Envoi le formulaire au back-end pour l'ajouter à la DB
   	$.post(addDepsAction,               
		  { taskid: idTask.innerHTML,
			new_deps: arrayTask
			},
		  addDepsInList,
		  "json");
	
	// Détruit la PopUp
	destroyPopUpAddDepsTask();
}

function addDepsInList(answer)
{
	// TODO later
}