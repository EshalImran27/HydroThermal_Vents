const registerLink = document.getElementById('register-link');
const loginLink = document.getElementById('login-link');
const flipper = document.querySelector('.flipper');
const loginpage = document.querySelector('.login-page');
const loginForm = document.querySelector('.login-form');
const registerForm = document.querySelector('.register-form');
registerLink?.addEventListener('click', (e) => {
    e.preventDefault();
    flipper.classList.add('flipped');
});

loginLink?.addEventListener('click', (e) => {
    e.preventDefault();
    flipper.classList.remove('flipped');
});
