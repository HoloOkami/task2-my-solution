$( document ).ready(function() {
	$("#submit").click(
		function(){
			sendForm();
			return false; 
		}
	);
});

function sendForm() {
	jQuery.ajax({
		url: "actions/FormPost.php",
		type: "POST",
		dataType: "html",
		data: jQuery("#form").serialize(),
		success: function(response) {
			result = jQuery.parseJSON(response);
			if (result.shortPart) {
				document.getElementById("result").innerHTML = 
					'<a href="' + result.site + result.shortPart + '" target="_blank">' + result.site + result.shortPart + '</a>';
			} else if (result.shortPart === null) {
				document.getElementById("result").innerHTML = "Не удалось сгенерировать URL.";
			} else {
				document.getElementById("result").innerHTML = "Неверный сокращенный URL.<br>" +
																			 "Проверьте правильность ввода. " +
																			 "Сокращенный URL должен состоять из 6 букв латинского алфавита" +
																			 " в любом регистре и/или цифр.<br>" +
																			 "Если все верно, то, возможно, такой URL уже существует.";
			}
		},
		error: function(response) {
			document.getElementById("#result").innerHTML = "Ошибка. Данные не отправлены.";
		}
	});
}