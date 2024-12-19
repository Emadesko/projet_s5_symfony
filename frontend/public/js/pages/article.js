import ApiServive from "../ApiService.js"
const apiService = new ApiServive();
let datas = await getElements("article/api?dispo=oui")
const tbodyArticles = document.getElementById("tbodyArticles")
const searchArticleBtn = document.getElementById("searchArticleBtn")
const pagination = document.getElementById("pagination")
const rupture = document.getElementById("rupture")
const dispoDiv = document.getElementById("dispo")
const searchArticle = document.getElementById("searchArticle")
const all = document.getElementById("all")
let articles = datas.datas
let page = datas.page
let maxPage = datas.maxPage
let dispo = datas.dispo
let libelle = datas.libelle

show(articles, page, maxPage)

async function getElements(endpoint) {
  return apiService.getElements(endpoint);
}

function show(datas, page, max) {
  tbodyArticles.innerHTML = "";
  pagination.innerHTML = ""
  if (datas.length == 0) {
    tbodyArticles.innerHTML = `Aucun article`
  } else if (max > 1) {
    for (let i = 1; i <= max; i++) {
      const btn = document.createElement("button")
      btn.textContent = i
      if (i == page) {
        btn.classList.add(...`px-3 py-1 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600`.split(' '))
      } else {
        btn.classList.add(...`px-3 py-1 bg-gray-300 rounded-md shadow hover:bg-gray-400`.split(' '))
      }
      btn.addEventListener('click', async function () {
        datas = await getElements(`article/api?page=${i}&libelle=${libelle}&dispo=${dispo}`)
        dispo = datas.dispo
        show(datas.datas, datas.page, datas.maxPage)
      })
      pagination.appendChild(btn)
    }
  }

  datas.forEach(article => {
    const tr = document.createElement("tr")
    tr.classList.add("border-t")
    tr.innerHTML = `
                    <td class="py-2 px-4 text-center">${article.libelle}</td>
                    <td class="py-2 px-4 text-center">${article.prix}</td>
                    <td class="py-2 px-4 text-center">${article.qteStock}</td>
                    <td class="py-2 px-4 text-center">${article.reference}</td>
                        `
    tbodyArticles.appendChild(tr);
  });
}

searchArticleBtn.addEventListener('click', async function () {
  if (searchArticle.value.trim()) {
    datas = await getElements(`article/api?libelle=${searchArticle.value.trim()}&dispo=${dispo}`)
    dispo = datas.dispo
    show(datas.datas, datas.page, datas.maxPage)
  } else {
    datas = await getElements("article/api?dispo="+dispo)

    show(datas.datas, page, maxPage, "")
  }
})

rupture.addEventListener('click', async function () {
    searchArticle.value=""
    datas = await getElements("article/api?dispo=non")
    dispo = datas.dispo
    show(datas.datas, datas.page, datas.maxPage)
})

dispoDiv.addEventListener('click', async function () {
    searchArticle.value=""
    datas = await getElements("article/api?dispo=oui")
    dispo = datas.dispo
    show(datas.datas, datas.page, datas.maxPage)
})

all.addEventListener('click', async function () {
    searchArticle.value=""
    datas = await getElements("article/api")
    dispo = ""
    show(datas.datas, datas.page, datas.maxPage)
})
