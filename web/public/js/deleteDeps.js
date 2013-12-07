// Ajoute les �v�nements li�s aux boutons de delete des d�pendances des t�ches
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
	// Avec les parametres 	taskid (id tache sur laquelle on supprime une d�pendance)
	// 						dep_id (id de la tache d�pendante que l'on supprime)
	// Appel la methode todoOnAnswer lors de la r�ponse
	// type de r�ponse : json
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
