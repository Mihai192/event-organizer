const sidebar = document.querySelector('#sidebar');
const main    = document.querySelector('#main');
document.querySelector('#toggle').addEventListener('click', (e) => {
	sidebar.classList.toggle('deactivated');
	main.classList.toggle('move');
});