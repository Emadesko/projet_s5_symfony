import ApiServive from "../ApiService.js"
const apiService = new ApiServive();
let datas = await getElements("client/api")
const tbody = document.getElementById("tbody")
const searchClientBtn = document.getElementById("searchClientBtn")
const pagination = document.getElementById("pagination")
let clients = datas.datas
let page = datas.page
let maxPage = datas.maxPage
let telephone = datas.telephone

show(clients, page, maxPage)

async function getElements(endpoint) {
  return apiService.getElements(endpoint);
}

function show(datas, page, max) {
  tbody.innerHTML = "";
  pagination.innerHTML = ""
  if (datas.length == 0) {
    tbody.innerHTML = `Aucun client`
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
        datas = await getElements(`client/api?page=${i}&telephone=${telephone}`)
        show(datas.datas, datas.page, datas.maxPage)
      })
      pagination.appendChild(btn)
    }
  }

  datas.forEach(client => {
    const tr = document.createElement("tr")
    tr.classList.add("border-t")
    tr.innerHTML = `<td class="px-6 py-4">${client.surname}</td>
                <td class="px-6 py-4">${client.telephone}</td>
                <td class="px-6 py-4">${client.adresse}</td>
                <td class="px-6 py-4">${client.montant}</td>
                <td class="px-6 py-4">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
                    Détails
                    </button>
                </td>`
    tbody.appendChild(tr);
  });
}

searchClientBtn.addEventListener('click', async function () {
  const searchClient = document.getElementById("searchClient")
  if (searchClient.value.trim()) {
    datas = await getElements("client/api?telephone=" + searchClient.value.trim())
    show(datas.datas, datas.page, datas.maxPage)
  } else {
    show(clients, page, maxPage)
  }
})
