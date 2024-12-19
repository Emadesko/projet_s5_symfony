import ApiServive from "../ApiService.js"
const apiService = new ApiServive();
let datas = await getElements("demande/api")
const tbodyDemandes = document.getElementById("tbodyDemandes")
const pagination = document.getElementById("pagination")
const rejeter = document.getElementById("rejeter")
const enCours = document.getElementById("enCours")
const accepter = document.getElementById("accepter")
let demandes = datas.datas
let page = datas.page
let maxPage = datas.maxPage
let etat = datas.etat

let libelle = datas.libelle

show(demandes, page, maxPage)

async function getElements(endpoint) {
  return apiService.getElements(endpoint);
}

function show(datas, page, max) {
    
  tbodyDemandes.innerHTML = "";
  pagination.innerHTML = ""
  if (datas.length == 0) {
    tbodyDemandes.innerHTML = `Aucun demande`
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
        datas = await getElements(`demande/api?page=${i}&etat=${etat}`)
        etat = datas.etat
        
        show(datas.datas, datas.page, datas.maxPage)
      })
      pagination.appendChild(btn)
    }
  }

  datas.forEach(demande => {
    const tr = document.createElement("tr")
    tr.classList.add("border-t")
    tr.innerHTML = `
                        <td class="border-t border-gray-200 py-2 px-4 text-center">${demande.createAt}</td>
                        <td class="border-t border-gray-200 py-2 px-4 text-center">${demande.montant} FCFA</td>
                        <td class="border-t border-gray-200 py-2 px-4 text-center">${demande.client.compte.nom} ${demande.client.compte.prenom}
                        </td>
                        <td class="border-t border-gray-200 py-2 px-4 text-center">${demande.client.telephone}</td>
                        <td class="border-t border-gray-200 py-2 px-4 text-center">${demande.etat}</td>
                        <td class="border-t border-gray-200 py-2 px-4 text-center">
                            <a href="../Boutiquier/detailDemandes.html"><button class="bg-gray-500 hover:bg-gray-400 text-white py-1 px-4 rounded">
                                    <i class="fas fa-eye"></i>Détails
                                </button></a>
                        </td>
                        `
    tbodyDemandes.appendChild(tr);
  });
}


rejeter.addEventListener('click', async function () {
    datas = await getElements("demande/api?etat=1")
    etat = datas.etat
    
    show(datas.datas, datas.page, datas.maxPage)
})

enCours.addEventListener('click', async function () {
    datas = await getElements("demande/api")
    etat = datas.etat
    
    show(datas.datas, datas.page, datas.maxPage)
})

accepter.addEventListener('click', async function () {
    datas = await getElements("demande/api?etat=2")
    etat = datas.etat
    
    show(datas.datas, datas.page, datas.maxPage)
})
