// Ajoute les �v�nements li�s aux boutons d'ajout de d�pendances entre t�ches
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
	// Appel la methode showFormAddDepths lors de la r�ponse
	// type de r�ponse : json
	$.post(addDepsFormAction,               
		  { taskid: targ.id },
		  showFormAddDeps,
		  "json");
}

function showFormAddDeps(answer)
{
	if (answer.taskid == null && answer.deps == null)
		return;
		
	// Div principale du message � afficher
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
	
	
	// Formulaire de choix des d�pendances
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
		// D�serialize le tableau re�u
		var task_deserialise = JSON.parse(answer.deps[i]);
		
		// Cr� une option au select
		var optionTask = document.createElement('option');
		optionTask.value = task_deserialise.id;
		optionTask.appendChild( document.createTextNode( task_deserialise.name ) );
		
		// Ajoute l'option au select
		selectTasks.appendChild(optionTask);
	}
	
	form.appendChild(selectTasks);
	
	// Champs cach� contenant l'id de la task � laquelle on veut ajouter des d�pendances
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
	// R�cup�re l'id de la tache � laquelle on ajoute des d�pendances
   var idTask = document.getElementById('taskAsker');
   // R�cup�re les options du formulaire d'ajout de d�pendance
   var tasks = document.getElementsByTagName('option');
   
   // Initialise arrayTask avec les taches d�pendantes s�lectionn�es
   var arrayTask = new Array();
   for (var i = 0 ; i < tasks.length ; i++)
   {
		if (tasks[i].selected)
			arrayTask.push(tasks[i].value);
   }
   
   // Envoi le formulaire au back-end pour l'ajouter � la DB
   	$.post(addDepsAction,               
		  { taskid: idTask.innerHTML,
			new_deps: arrayTask
			},
		  addDepsInList,
		  "json");
	
	// D�truit la PopUp
	destroyPopUpAddDepsTask();
}

function addDepsInList(answer)
{
	// TODO later
}