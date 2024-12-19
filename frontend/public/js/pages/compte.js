import ApiServive from "../ApiService.js"
const apiService = new ApiServive();
let datas = await getElements("compte/api")
const tbodyComptes = document.getElementById("tbodyComptes")
const pagination = document.getElementById("pagination")
const client = document.getElementById("clientR")

const admin = document.getElementById("admin")
const all = document.getElementById("all")
const boutiquier = document.getElementById("boutiquier")
let comptes = datas.datas
let page = datas.page
let maxPage = datas.maxPage
let role = datas.role

show(comptes, page, maxPage)

async function getElements(endpoint) {
  return apiService.getElements(endpoint);
}

function show(datas, page, max,) {
  tbodyComptes.innerHTML = "";
  pagination.innerHTML = ""
  if (datas.length == 0) {
    tbodyComptes.innerHTML = `Aucun compte`
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
        datas = await getElements(`compte/api?page=${i}&role=${role}`)
        role = datas.role
        show(datas.datas, datas.page, datas.maxPage)
      })
      pagination.appendChild(btn)
    }
  }

  datas.forEach(compte => {
    const tr = document.createElement("tr")
    tr.classList.add("border-t")
    tr.innerHTML = `
                    <td class="border-t border-gray-200 py-2 px-4 text-center">${compte.role}</td>
                    <td class="border-t border-gray-200 py-2 px-4 text-center">${compte.nom}</td>
                    <td class="border-t border-gray-200 py-2 px-4 text-center">${compte.prenom}</td>
                    <td class="border-t border-gray-200 py-2 px-4 text-center">${compte.email}</td>
                        `
    tbodyComptes.appendChild(tr);
  });
}

async function filtre(parm){
  if (parm.toString().trim()) {
    parm=`?role=${parm}`
  }
  datas = await getElements(`compte/api${parm}`)
  role = datas.role
  show(datas.datas, datas.page, datas.maxPage)
}


client.addEventListener('click', async function () {
    await filtre(0)
})

boutiquier.addEventListener('click', async function () {
    await filtre(1)
})

admin.addEventListener('click', async function () {
  await filtre(2)
})

all.addEventListener('click', async function () {
    await filtre("")
})
