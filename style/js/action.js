const date =  document.querySelector('.date')
let compte = document.querySelector('.compte')
let libelle = document.querySelector('.libelle')
let debit = document.querySelector('.debit')
let credit = document.querySelector('.credit')
const Enregister = document.querySelector('#Enregister')
const tbody = document.querySelector('#tbody')

function ajoutTab(neud) {
    const newline = document.createElement("td")
    const contenu = document.createTextNode(neud.value)
    newline.appendChild(contenu)
    return newline
}

save = ['2022-08-18','512','banque','50000000000','']
save.forEach( ajout => ajoutTab(ajout));

Enregister.addEventListener('click',() => {

    //console.log(credit)
    if(date && compte && libelle){
        //traitement de date
        Adddate = ajoutTab(date)
        const newcol = document.createElement('tr')
        newcol.appendChild(Adddate)
        tbody.appendChild(newcol)

        //traitement de compte
        Addcompte = ajoutTab(compte)
        newcol.appendChild(Addcompte)

        //traitement de libelle
        Addlibelle = ajoutTab(libelle)
        newcol.appendChild(Addlibelle)

        //traitement de debit
        Adddebit = ajoutTab(debit)
        newcol.appendChild(Adddebit)

        //traitement de credit
        Addcredit = ajoutTab(credit)
        newcol.appendChild(Addcredit)
    }

    /*vider les formulaires
    compte.value = ''
    libelle.value = ''
    debit.value = ''
    credit.value = ''*/

})
