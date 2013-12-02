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
    $.post("{{path('tms_tasks_manager_add_dep_form')}}",               
          {taskid: targ.id }, //> remplacer par l'id de la tache
          showFormAddDeps,
		  "json");
}

function showFormAddDeps(answer)
{
	// Div principale du message à afficher
	var divPopUp = document.createElement('div');
	divPopUp.id = 'addDepsForm';
	
	// Chaines de textes
	var textNodes = [
		document.createTextNode('Choose task dependances :'),
		document.createTextNode('Cancel')
	];
	
	// Paragraphe d'introduction
	var message = document.createElement('p');
	message.appendChild(textNodes[0]);
	
	
	// Paragraphe du formulaire de choix des dépendances
	var choseDeps = document.createElement('p');
	
	var form = document.createElement('form');
	form.action  = tms_tasks_manager_add_dep;
	form.enctype = 'multipart/form-data';
	form.method  = 'post';
	
	// Boucle pour afficher toutes les taches possibles
	for (var i = 0 ; i < answer.deps.length ; i++)
	{
		var checkBox = document.createElement('input');
		checkBox.type = 'checkbox';
		checkBox.id   = 'checkBox'+i;
		checkBox.name = input.id;
		
		var nameTask = document.createElement('p');
		nameTask.appendChild(answer.deps.getName());
	}
	
	var submit = document.createElement('input');
	submit.type  = 'submit';
	submit.value = 'Add';
	form.appendChild(submit);
	
	choseDeps.appendChild(form);
	
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
	divPopUp.appendChild(choseDeps);
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