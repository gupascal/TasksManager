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
	e.preventDefault();
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
		optionTask.className = 'depOption';
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
	e.preventDefault();
	// R�cup�re l'id de la tache � laquelle on ajoute des d�pendances
   var idTask = document.getElementById('taskAsker');
   // R�cup�re les options du formulaire d'ajout de d�pendance
   var tasks = document.getElementsByTagName('option');
   
   // Initialise arrayTask avec les taches d�pendantes s�lectionn�es
   var arrayTask = new Array();
   for (var i = 0 ; i < tasks.length ; i++)
   {
		if (tasks[i].selected && tasks[i].classList.contains('depOption'))
			arrayTask.push(tasks[i].value);
   }

   // Envoi le formulaire au back-end pour l'ajouter � la DB
   	$.post(addDepsAction,               
		  { taskid: idTask.innerHTML,
			new_deps: arrayTask
			},
		  addDepsInList,
		  "json");
}

function addDepsInList(answer)
{
	if (answer.taskid == null || answer.deps == null)
		return;
	
	// R�cup�re la div des d�pendances de la t�che avec l'id answer.taskid
	var divDepsTask = $('#task_' + answer.taskid).children(".depTask");
	
	if(divDepsTask.length)	// si existe on est soit sur la liste des taches, soit sur le dashboard
	{
		// R�cup�re la div de listage des t�ches d�pendantes
		var divDepList = divDepsTask.children(".depList");
		
		// Test si la div de listage des d�pendances existe
		if(!divDepList.length)	// existe pas
		{
			// Cr�e la div de listage des d�pendances
			divDepsTask.append('<div class="depList">')
			// R�cup�re la balise de listage des d�pendances puisque elle n'existait pas avant
			divDepList = divDepsTask.children(".depList");
		}
		addDepsToPage(answer.taskid, answer.deps, divDepList);
	}
	else	// on est sur la page show task
	{
		// R�cup�re la div des d�pendances
		var divDepsList = $('#depTaskList');
		if (!divDepsList.length)	// si elle n'exitse pas on la cr�e
		{
			// R�cup�re la div parente pour l'affichage des taches d�pendantes
			var divDeps = $('#depTask');
			divDeps.append('<p>Dependent task:</p>');
			divDeps.append('<div id="depTaskList">');
			
			divDepsList = $('#depTaskList');
		}
		addDepsToPage(answer.taskid, answer.deps, divDepsList)
	}
	
	// D�truit la PopUp
	destroyPopUpAddDepsTask();
}

function addDepsToPage(taskid, deps, balise)
{
	// On va ajouter toute les d�pendances voulues � la div de listage
	for (var i = 0 ; i < deps.length ; i++)
	{
		// D�serialize le tableau re�u
		var task_deserialise = JSON.parse(deps[i]);
		
		// Ajoute les informations d�sir�es de la d�pendance dans la liste des d�pendances
		balise.append('<p><a id="' + taskid + '_' + task_deserialise.id + '" class="removeDeps" href="#"><img src="' + imgCrossDelete + '" alt="delete cross"></a> ' + task_deserialise.name + '</p>');
	
		// Une fois le lien ajout�, il faut lui ajouter l'�v�nement dessus pour pouvoir la supprimer
		var idDepAdded = String(taskid + '_' + task_deserialise.id);	// Id du lien
		var dep = document.getElementById(idDepAdded);
		addEvent(dep, 'click', deleteDep);
	}
}