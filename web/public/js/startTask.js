// Ajoute les évènements liés aux boutons de début de tâche
var aStartDeps = document.getElementsByTagName('a');	
for (var i = 0 ; i < aStartDeps.length ; i++)
{
	if (aStartDeps[i].classList.contains('startTask')) {
		addEvent(aStartDeps[i], 'click', startTask);
	}
}

function startTask(e)
{
	e.preventDefault();	// On bloque l'action par défaut de cet élément
	var targ = getTarget(e);
	var idTask = String(targ.id).split("_", 2);

	// Envoi un formulaire post vers le lien tms_tasks_manager_remove_dep
	// Avec les parametres 	taskid (id tache que l'on commence)
	// Appel la methode todoOnAnswer2 lors de la réponse
	// type de réponse : json
	$.post(startTaskLink,               
		  { taskid: idTask[1]},
		  todoOnAnswer2,
		  "json");
}

function todoOnAnswer2(answer)
{
	alert("task started");
}
