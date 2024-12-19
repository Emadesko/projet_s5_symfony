    const article = document.getElementById('article');
    const client = document.getElementById('client');
    const dashboard = document.getElementById('dashboard');
    const demande = document.getElementById('demande');
    const dette = document.getElementById('dette');
    const compte = document.getElementById('compte');
    const main = document.getElementById('main');

    async function loadContent(page) {
        const response = await fetch(`pages/${page}s.html`);
        const html = await response.text();
  
        main.innerHTML = html;

        const script = document.createElement("script");
        script.src = `js/pages/${page}.js?reload=${new Date().getTime()}`;
        script.type = "module";
        main.appendChild(script);
      }

    article.addEventListener('click',() => loadContent('article'));
    client.addEventListener('click',() => loadContent('client'));
    dashboard.addEventListener('click',() => loadContent('dashboard'));
    demande.addEventListener('click',() => loadContent('demande'));
    dette.addEventListener('click',() => loadContent('dette'));
    compte.addEventListener('click',() => loadContent('compte'));

