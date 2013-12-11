// Ajoute les �v�nements li�s aux boutons de d�but de t�che
var aStartDeps = document.getElementsByTagName('a');	
for (var i = 0 ; i < aStartDeps.length ; i++)
{
	if (aStartDeps[i].classList.contains('startTask')) {
		addEvent(aStartDeps[i], 'click', startTask);
	}
}

function startTask(e)
{
	e.preventDefault();	// On bloque l'action par d�faut de cet �l�ment
	var targ = getTarget(e);
	var idTask = String(targ.id).split("_", 2);

	// Envoi un formulaire post vers le lien tms_tasks_manager_remove_dep
	// Avec les parametres 	taskid (id tache que l'on commence)
	// Appel la methode replacDateStarted lors de la r�ponse
	// type de r�ponse : json
	$.post(startTaskLink,               
		  { taskid: idTask[1]},
		  replacDateStarted,
		  "json");
}

function replacDateStarted(answer)
{
	if (answer.taskid == null || answer.date_started == null)
		return;
	
	// Construit l'id du lien qui a demand� � commencer la tache
	// Pour ensuite r�cup�rer la balise parente et remplacer son contenu
	var idElementToReplace = String('#start_' + answer.taskid);
	
	// D�serialize le tableau re�u
	var task_date_deserialise = JSON.parse(answer.date_started);
	
	// Texte qui va remplacer l'ancien texte
	var txtReplace = "Started the: " + task_date_deserialise;
	
	// Paragraphe de la date de d�part de la t�che
	var elementDateStarted = $(idElementToReplace).parent();
	
	// Remplace par le nouveau bon texte avec la date mise � jour
	elementDateStarted.html(txtReplace);
	
	// On va modifier le p de la date de fin pour ajouter un lien pour terminer la t�che
	// Paragraphe suivant de celui de la date de d�part
	var idFinishLink = String('finish_' + answer.taskid);	// Id du lien
	elementDateStarted.next().append(' | <a id="' + idFinishLink + '" class="timeUpdate finishTask" href="#">Finish</a>');
	
	// Une fois le lien ajout�, il faut lui ajouter l'�v�nement dessus pour finir la t�che dessus
	var aStartDeps = document.getElementById(idFinishLink);
	addEvent(aStartDeps, 'click', finishTask);
}
