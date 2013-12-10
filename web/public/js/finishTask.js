// Ajoute les �v�nements li�s aux boutons de fin de t�che
var aFinishDeps = document.getElementsByTagName('a');	
for (var i = 0 ; i < aFinishDeps.length ; i++)
{
	if (aFinishDeps[i].classList.contains('finishTask')) {
		addEvent(aFinishDeps[i], 'click', finishTask);
	}
}

function finishTask(e)
{
	e.preventDefault();	// On bloque l'action par d�faut de cet �l�ment
	var targ = getTarget(e);
	var idTask = String(targ.id).split("_", 2);

	// Envoi un formulaire post vers le lien tms_tasks_manager_remove_dep
	// Avec les parametres 	taskid (id tache que l'on finit)
	// Appel la methode replacDateCompleted lors de la r�ponse
	// type de r�ponse : json
	$.post(finishTaskLink,               
		  { taskid: idTask[1]},
		  replacDateCompleted,
		  "json");
}

function replacDateCompleted(answer)
{
	if (answer.taskid == null || answer.date_completed == null)
		return;
		
	// Construit l'id du lien qui a demand� � terminer la tache
	// Pour ensuite r�cup�rer la balise parente et remplacer son contenu
	var idElementToReplace = String('#finish_' + answer.taskid);
	
	// D�serialize le tableau re�u
	var task_date_deserialise = JSON.parse(answer.date_completed);
	
	// Texte qui va remplacer l'ancien texte
	var txtReplace = "Finished the: " + task_date_deserialise;
	
	// Remplace par le nouveau bon texte avec la date mise � jour
	$(idElementToReplace).parent().html(txtReplace);
}
