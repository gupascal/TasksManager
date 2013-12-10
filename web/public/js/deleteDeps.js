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
	e.preventDefault();	// On bloque l'action par défaut de cet élément
	var targ = getTarget(e);
	var ids = String(targ.parentNode.id).split("_", 2);

	// Envoi un formulaire post vers le lien tms_tasks_manager_remove_dep
	// Avec les parametres 	taskid (id tache sur laquelle on supprime une dépendance)
	// 						dep_id (id de la tache dépendante que l'on supprime)
	// Appel la methode RemoveDepFromPage lors de la réponse
	// type de réponse : json
	$.post(removeDepAction,               
		  { taskid: ids[0],
			dep_id: ids[1]
			},
		  RemoveDepFromPage,
		  "json");
}

function RemoveDepFromPage(answer)
{
	if (answer.taskid == null || answer.dep_id == null)
		return;
		
	// Construit l'id du lien qui a demandé à supprimer la dépendance
	// Pour ensuite récupérer la balise parente et la supprimer
	var idElementToDelete = String('#' + answer.taskid + '_' + answer.dep_id);
	var divDeps = $(idElementToDelete).parent().parent();	// Div contenant les dépendances
	
	// Supprime la dépendance de la page
	$(idElementToDelete).parent().remove();
	
	// On vérifie s'il reste encore d'autres dépendances dans la div
	var length = $(divDeps).children().length;
	
	// S'il ne reste plus de dépendences on supprime la div des dépendances
	if (length > 0)
		return;
	
	divDeps.remove();
}
