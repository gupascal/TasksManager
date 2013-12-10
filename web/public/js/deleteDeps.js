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
	e.preventDefault();	// On bloque l'action par d�faut de cet �l�ment
	var targ = getTarget(e);
	var ids = String(targ.parentNode.id).split("_", 2);

	// Envoi un formulaire post vers le lien tms_tasks_manager_remove_dep
	// Avec les parametres 	taskid (id tache sur laquelle on supprime une d�pendance)
	// 						dep_id (id de la tache d�pendante que l'on supprime)
	// Appel la methode RemoveDepFromPage lors de la r�ponse
	// type de r�ponse : json
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
		
	// Construit l'id du lien qui a demand� � supprimer la d�pendance
	// Pour ensuite r�cup�rer la balise parente et la supprimer
	var idElementToDelete = String('#' + answer.taskid + '_' + answer.dep_id);
	var divDeps = $(idElementToDelete).parent().parent();	// Div contenant les d�pendances
	
	// Supprime la d�pendance de la page
	$(idElementToDelete).parent().remove();
	
	// On v�rifie s'il reste encore d'autres d�pendances dans la div
	var length = $(divDeps).children().length;
	
	// S'il ne reste plus de d�pendences on supprime la div des d�pendances
	if (length > 0)
		return;
	
	divDeps.remove();
}
