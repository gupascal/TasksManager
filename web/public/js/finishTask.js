// Ajoute les évènements liés aux boutons de fin de tâche
var aFinishDeps = document.getElementsByTagName('a');	
for (var i = 0 ; i < aFinishDeps.length ; i++)
{
	if (aFinishDeps[i].classList.contains('finishTask')) {
		addEvent(aFinishDeps[i], 'click', finishTask);
	}
}

function finishTask(e)
{
	e.preventDefault();	// On bloque l'action par défaut de cet élément
	var targ = getTarget(e);
	var idTask = String(targ.id).split("_", 2);

	// Envoi un formulaire post vers le lien tms_tasks_manager_remove_dep
	// Avec les parametres 	taskid (id tache que l'on finit)
	// Appel la methode todoOnAnswer3 lors de la réponse
	// type de réponse : json
	$.post(finishTaskLink,               
		  { taskid: idTask[1]},
		  todoOnAnswer3,
		  "json");
}

function todoOnAnswer3(answer)
{
	alert("task finished");
}
