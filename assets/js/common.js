jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "delete_user",
			currentRow = $(this);
		
		var confirmation = confirm("Êtes-vous certains de vouloir supprimer cet utilisateur ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Utilisateur supprimé avec succès"); }
				else if(data.status = false) { alert("La suppression de l'utilisateur a échoué"); }
				else { alert("Accès interdit..!"); }
			});
		}
	});
});
