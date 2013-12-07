// Ajoute les évènements liés aux boutons de delete des dépendances des tâches
var aDeleteDeps = document.getElementsByTagName('a');	
for (var i = 0 ; i < aDeleteDeps.length ; i++)
{
	if (aDeleteDeps[i].classList.contains('removeDeps')) {
		addEvent(aDeleteDeps[i], 'click', deleteDep);
	}
}

function deleteDep(e)
{
	var targ = getTarget(e);
	var ids = String(targ.parentNode.id).split("_", 2);

	// Envoi un formulaire post vers le lien tms_tasks_manager_remove_dep
	// Avec les parametres 	taskid (id tache sur laquelle on supprime une dépendance)
	// 						dep_id (id de la tache dépendante que l'on supprime)
	// Appel la methode todoOnAnswer lors de la réponse
	// type de réponse : json
	$.post(removeDepAction,               
		  { taskid: ids[0],
			dep_id: ids[1]
			},
		  todoOnAnswer,
		  "json");
}

function todoOnAnswer(answer)
{
	alert("deps removed");
}
