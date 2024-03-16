const signUpBtnLink = document.querySelector(".signUpBtn-link");
const signInBtnLink = document.querySelector(".signInBtn-link");
const wrapper = document.querySelector(".wrapper");

signUpBtnLink.addEventListener('click', () => {
	console.log("click")
	wrapper.classList.toggle("active");
})

signInBtnLink.addEventListener('click', () => {
	console.log("click")
	wrapper.classList.toggle("active");
})

