<html>

<head>
	<meta charset="utf-8" />
	<title>App Mail Send</title>

	<link rel="shortcut icon" type="image/jpg" href="Assets/logo.png"/>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body style="font-family: 'Lato', sans-serif;">

	<nav class="h-[5%] absolute bg-cyan-500">

	</nav>


	<div class="flex flex-col mx-auto justify-center md:pt-[10%] md:pt-[5%] lg:pt-[2.5%] items-center bg-zinc-200 h-screen overflow-hidden">

		<div class="flex flex-col items-center text-zinc-800">
			<img class="block w-[80%] md:w-[35%] lg:w-[20%] object-contain" src="Assets/logo.png">
			<h2 class="font-bold uppercase text-8xl md:text-7xl lg:text-3xl my-[2%]">Send Mail</h2>
			<p class="text-5xl md:text-3xl lg:text-lg font-medium">Seu app de envio de e-mails particular!</p>
		</div>

		<div class="flex justify-center items-center w-full md:mt-[10%] lg:mt-[2.5%] h-auto">

			<form action="processa_envio.php" method="post" class="h-full w-full flex flex-col items-center px-[10%]">

				<div class="w-full">
					<label for="para" class="text-4xl text-zinc-800 lg:text-lg font-semibold">Para</label>
					<input name="para" type="text" class="w-full text-zinc-700 py-[2.5%] outline-none focus:ring-inset focus:ring-2 ring-cyan-500 duration-300 lg:py-[0.5%] px-[1%] font-medium px-[1.5%] text-3xl lg:text-sm mt-[1.5%] lg:mt-[0.5%] mb-[2.5%] lg:mb-[1.5%] rounded-lg" id="para" placeholder="Example@gmail.com.br">
				</div>

				<div class="w-full">
					<label for="assunto" class="text-4xl text-zinc-800 font-semibold lg:text-lg">Assunto</label>
					<input name="assunto" type="text" class="w-full text-zinc-700 py-[2.5%] outline-none focus:ring-inset focus:ring-2 ring-cyan-500 duration-300 lg:py-[0.5%] px-[1%] font-medium px-[1.5%] text-3xl lg:text-sm mt-[1.5%] lg:mt-[0.5%] mb-[2.5%] lg:mb-[1.5%] rounded-lg" id="assunto" placeholder="Assunto do e-mail">
				</div>

				<div class="w-full">
					<label for="mensagem" class="text-4xl text-zinc-800 font-semibold lg:text-lg">Mensagem</label>
					<textarea name="mensagem" rows="3" class="w-full text-zinc-700 h-auto outline-none focus:ring-inset focus:ring-2 ring-cyan-500 duration-300 p-[1%] py-[2.5%] md:py-[0.75%] text-3xl font-medium px-[1.5%] lg:mt-[0.5%] mt-[1.5%] lg:text-sm mb-[2.5%] lg:mb-[1.5%] rounded-lg" id="mensagem"></textarea>
				</div>

				<button type="submit" class="bg-cyan-500 font-bold px-[10%] py-[3%] mt-[3%] lg:py-[0.5%] lg:mt-[1%] lg:px-[3%] uppercase text-2xl rounded-sm lg:text-lg tracking-wider text-zinc-50">Enviar</button>
			</form>

		</div>
	</div>

</body>

<script>
	document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input, textarea');

    inputs.forEach(input => {
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const nextInputIndex = Array.from(inputs).indexOf(input) + 1;

                if (nextInputIndex < inputs.length) {
                    inputs[nextInputIndex].focus();
                } else {
                    if (areAllFieldsFilled()) {
                        document.querySelector('form').submit();
                    }
                }

                e.preventDefault();
            }
        });
    });

    function areAllFieldsFilled() {
        let allFieldsFilled = true;

        inputs.forEach(input => {
            if (input.value.trim() === '') {
                allFieldsFilled = false;
            }
        });

        return allFieldsFilled;
    }
});
</script>

</html>