const	signUpBtnLink = document.querySelector(".signUpBtn-link");
const	signInBtnLink = document.querySelector(".signInBtn-link");
const	wrapper = document.querySelector(".wrapper");

signUpBtnLink.addEventListener('click', () => {
	console.log("click")
	wrapper.classList.toggle("active");
})

signInBtnLink.addEventListener('click', () => {
	console.log("click")
	wrapper.classList.toggle("active");
})

/* --- POST login form --- */
document.getElementById("loginForm").addEventListener('submit', function(event) {
	event.preventDefault();
	// Get data from form
	const	login = document.getElementById('loginId').value;
	const	password = document.getElementById('passwordIdLogin').value;

	// Create data
	const	data = {
		login : login,
		password : password
	};

	// Post request option
	const option = {
		method: 'POST',
		headers: {
			'Content-Type' : 'application/json',
		},
		body: JSON.stringify(data),
	}
	console.log(option);
	// Fetch post
	fetch("https://www.camagru42.fr/login.php", option)
		.then(response => {
			if (!response.ok)
				throw new Error('Réponse réseau incorrecte');	
			return response.json();
		})
		.then(data => {
			console.log(`Reussite:`);
			console.log(data); // Affichez les données dans la console par exemple
		})
		.catch(error => {
			console.log("echec");
		})
})

/* --- POST register form --- */
document.getElementById("registerForm").addEventListener('submit', function(event) {
	event.preventDefault();
	// Get data from form
	const email = document.getElementById('emailId').value;
	const username = document.getElementById('registerId').value;
	const password = document.getElementById('passwordIdRegister').value;

	const data = {
		email : email,
		username : username,
		password : password
	};
	const option = {
		method: 'POST',
		headers: {
			'Content-Type' : 'application/json',
		},
		body: JSON.stringify(data),
	};
	fetch('https://www.camagru42.fr/register.php', option)
	.then(response => {
		if (!response.ok)
			throw new Error('Réponse réseau incorrecte');	
		return response.json();
	})
	.then(data => {
		console.log(`Reussite:`);
		console.log(data); // Affichez les données dans la console par exemple
	})
	.catch(error => {
		console.log("echec");
	})


})