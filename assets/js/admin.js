import '../css/admin.scss';

(() => {
  const elements = document.querySelectorAll('tr[data-href]');
  const addClickEvent = element => element.addEventListener('click', () => window.location = element.dataset.href);

  elements.forEach(addClickEvent);
})();
