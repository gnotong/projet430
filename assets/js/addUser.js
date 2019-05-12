$(document).ready(function(){

	var addUserForm = $("#addUser");

	var validator = addUserForm.validate({
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "check_email", type :"post"} },
			password : { required : true },
			cpassword : {required : true, equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "Ce champ est obligatoire" },
			email : { required : "Ce champ est obligatoire", email : "Cet email n'est pas valide", remote : "Email déjà utilisé" },
			password : { required : "Ce champ est obligatoire" },
			cpassword : {required : "Ce champ est obligatoire", equalTo: "Les mots de passes ne sont pas identiques" },
			mobile : { required : "Ce champ est obligatoire", digits : "Uniquement les chiffres allant de 0-9 sont autorisés" },
			role : { required : "Ce champ est obligatoire", selected : "Au moins un rôle doit être sélectionné" }
		}
	});
});
