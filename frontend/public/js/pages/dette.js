import ApiServive from "../ApiService.js"
const apiService = new ApiServive();

const pagination = document.getElementById("pagination")
const dettesClient = document.getElementById("dettesClient")
const clientInfo = document.getElementById("clientInfo")
const selectedTelephone = document.getElementById("selectedTelephone")
const selectedTelephoneBtn = document.getElementById("selectedTelephoneBtn")
const tbodyDette = document.getElementById("tbodyDette")

const creerCompteToggle = document.getElementById('creerCompte');
const accountFields = document.getElementById('accountFields');
const toggleLabel = document.getElementById('toggleLabel');
const noClient = document.getElementById("noClient")
let datas
let client
let page=1
let maxPage
let type=""


async function getElements(endpoint) {
    return apiService.getElements(endpoint);
}

function show(datas, page, max) {
    tbodyDette.innerHTML = "";
    pagination.innerHTML = ""
    if (datas.length == 0) {
        tbodyDette.innerHTML = `Aucune dette`
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
                datas = await getElements(`dette/api/client?page=${i}&id=${client.id}&type=${type}`)
                show(datas.datas, datas.page, datas.maxPage)
            })
            pagination.appendChild(btn)
        }
    }

    datas.forEach(dette => {
        const tr = document.createElement("tr")
        tr.classList.add("border-t")
        tr.innerHTML = `<td class="p-2 text-center">${dette.createAt}</td>
                        <td class="p-2 text-center">${dette.montant} FCFA</td>
                        <td class="p-2 text-center">${dette.montantVerser} FCFA</td>
                        <td class="p-2 text-center">${dette.montant - dette.montantVerser} FCFA</td>
                        <td class="p-2 text-center">
                            <button class="bg-blue-500 text-white px-4 py-1 rounded">Détails</button>
                        </td>`
        tbodyDette.appendChild(tr);
    });
}

selectedTelephoneBtn.addEventListener('click', async function () {
    noClient.innerHTML = ""
    if (selectedTelephone.value.trim()) {
        datas = await getElements("client/api/tel?telephone=" + selectedTelephone.value.trim())
        if (datas.datas) {
            client = datas.datas
            const detteBtn = document.getElementById("dettesBtn")
            const newDetteBtn = document.getElementById("newDetteBtn")
            const selectedSurnom = document.getElementById("selectedSurnom")
            const selectedAdresse = document.getElementById("selectedAdresse")

            selectedSurnom.value = client.surname
            selectedAdresse.value = client.adresse

            detteBtn.addEventListener('click', async function () {
                datas = await getElements("dette/api/client?id=" + client.id)
                page=datas.pageX
                maxPage=datas.maxPage
                type=datas.type
                clientInfo.classList.add('hidden')
                dettesClient.classList.remove('hidden')
                if (client.compte) {
                    const clientNom = document.getElementById("clientNom")
                    const clientEmail = document.getElementById("clientEmail")
                    const montant = document.getElementById("montant")
                    const montantVerser = document.getElementById("montantVerser")
                    const montantRestant = document.getElementById("montantRestant")

                    montant.innerText = client.montant
                    montantVerser.innerText = client.montantVerser
                    montantRestant.innerText = client.montant - client.montantVerser

                    clientNom.innerText += `${client.compte.nom} ${client.compte.prenom}`
                    clientEmail.innerText += client.compte.email
                }
                const clientSurnom = document.getElementById("clientSurnom")
                const clientTel = document.getElementById("clientTel")
                clientSurnom.innerText += client.surname
                clientTel.innerText += client.telephone
                
                show(datas.datas, page, maxPage)
                const nonSole = document.getElementById("nonSole")
                const solde = document.getElementById("solde")
                solde.addEventListener('click', async function(){
                    datas = await getElements("dette/api/client?id=" + client.id+"&type=" + 1)
                    page=datas.pageX
                    maxPage=datas.maxPage
                    type=datas.type
                    show(datas.datas, page, maxPage)
                })
                nonSole.addEventListener('click', async function(){
                    datas = await getElements("dette/api/client?id=" + client.id+"&type=" + 0)
                    page=datas.pageX
                    maxPage=datas.maxPage
                    type=datas.type
                    show(datas.datas, page, maxPage)
                })
            })
        } else {
            noClient.innerHTML = "Aucun client n'a ce numero"
            selectedTelephone.value = ""
        }
    }
})

creerCompteToggle?.addEventListener('change', function () {
    if (this.checked) {
        accountFields.classList.remove('hidden');
        toggleLabel.textContent = 'Oui';
    } else {
        accountFields.classList.add('hidden');
        toggleLabel.textContent = 'Non';
    }
});