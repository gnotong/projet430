$(document).ready(function(){
	
	var editUserForm = $("#editUser");
	
	var validator = editUserForm.validate({
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "check_email", type :"post", data : { userId : function(){ return $("#userId").val(); } } } },
			cpassword : {equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "Ce champ est obligatoire" },
			email : { required : "Ce champ est obligatoire", email : "Cet email n'est pas valide", remote : "Email déjà utilisé" },
			cpassword : {equalTo: "Les mots de passes ne sont pas identiques" },
			mobile : { required : "Ce champ est obligatoire", digits : "Uniquement les chiffres allant de 0-9 sont autorisés" },
			role : { required : "Ce champ est obligatoire", selected : "Au moins un rôle doit être sélectionné" }
		}
	});
});